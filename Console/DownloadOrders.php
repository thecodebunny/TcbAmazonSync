<?php

namespace Modules\TcbAmazonSync\Console;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use Illuminate\Console\Command;

use App\Models\Common\Item;
use App\Models\Common\Company;
use App\Models\Common\Contact;
use App\Models\Setting\Currency;
use App\Models\Banking\Transaction;

//Module NameSpaces
use Modules\TcbAmazonSync\Models\Amazon\Setting;
use Modules\TcbAmazonSync\Models\Amazon\SpApiSetting;
use Modules\TcbAmazonSync\Models\Amazon\Item as AmzItem;
use Modules\TcbAmazonSync\Models\Amazon\Asin as AmzAsin;
use Modules\TcbAmazonSync\Models\Amazon\Order as AmzOrder;
use Modules\TcbAmazonSync\Models\Amazon\OrderItem as AmzOrderItem;
use Modules\TcbAmazonSync\Http\Controllers\Amazon\Orders;

//SP API NameSpaces
use Thecodebunny\SpApi\Endpoint;
use Thecodebunny\SpApi\Configuration;
use Thecodebunny\SpApi\Api\OrdersApi;

//API NameSpaces

class DownloadOrders extends Command
{

    private $request;
    private $config;
    private $company_id;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'amazon:get-orders {country}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Downloads Amazon Orders';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        echo 'Running Order Download Cron At : ' . date("Y-m-d h:i:sa");
        $companies = Company::all();
        $country = $this->argument('country');
        foreach ($companies as $company) {
            $settings = SpApiSetting::where('company_id', $company->id)->first();
            if ($country == 'Us' || $country == 'Ca') {
                $endpoint = Endpoint::NA;
            } else {
                $endpoint = Endpoint::EU;
            }
            $config = new Configuration([
                "lwaClientId" => $settings->client_id,
                "lwaClientSecret" => $settings->client_secret,
                "lwaRefreshToken" => $settings->eu_token,
                "awsAccessKeyId" => $settings->ias_access_key,
                "awsSecretAccessKey" => $settings->ias_access_token,
                "endpoint" => $endpoint,
                "roleArn" => $settings->iam_arn
            ]);
            if ($settings && !empty($settings)) {
                if($country == 'Uk'){
                    $marketplace_ids = ['A1F83G8C2ARO7P'];
                }
                if($country == 'De'){
                    $marketplace_ids = ['A1PA6795UKMFR9'];
                }
                if($country == 'Fr'){
                    $marketplace_ids = ['A13V1IB3VIYZZH'];
                }
                if($country == 'It'){
                    $marketplace_ids = ['APJ6JRA9NG5V4'];
                }
                if($country == 'Es'){
                    $marketplace_ids = ['A1RKKUPIHCS9HS'];
                }
                if($country == 'Se'){
                    $marketplace_ids = ['A2NODRKZP88ZB9'];
                }
                if($country == 'Nl'){
                    $marketplace_ids = ['A1805IZSGTT6HS'];
                }
                if($country == 'Pl'){
                    $marketplace_ids = ['A1C3SOZRARQ6R3'];
                }
                if($country == 'Us'){
                    $marketplace_ids = ['ATVPDKIKX0DER'];
                }
                if ($country == 'Ca') {
                    $mpIds = ['A2EUQ1WTGCTBG2'];
                }
                $created_after = date('Y-m-d', strtotime('-2 days'));
                $apiInstance = new OrdersApi($config);
                $data_elements = [];
                try {
                    $result = $apiInstance->getOrders(
                        $marketplace_ids,
                        $created_after
                    );
                    $orders = $result['payload']['orders'];
                    foreach ($orders as $order) {
                        sleep(30);
                        try {
                            $this->createDbOrder($order, $company->id, $config, $country);
                        } catch (Exception $e) {
                            echo 'Problem with Order Import for ' . $country . ' Error : ' . $e->getMessage() . 'AMZ Order Number - ' . $order->getAmazonOrderId();
                        }
                        continue;
                    }

                } catch (Exception $e) {
                    echo 'Problem with Order Import for ' . $country . ' Error : ' . $e->getMessage();
                }
            }
        }
    }

    public function createDbOrder($order, $company_id, $config, $country)
    {
        if ($order->getOrderStatus() !== 'Canceled') {
            $customer = $this->getOrderBuyer($order->getAmazonOrderId(), $config);
            $address = $this->getOrderAddress($order->getAmazonOrderId(), $config);
            $items = $this->getOrderItems($order->getAmazonOrderId(), $config);
            $currency = $order->getOrderTotal()->getCurrencyCode();
            try {
                $this->createUpdateCustomer($order, $customer, $address, $currency, $items, $company_id, $country);
            } catch (Exception $e) {
                echo 'Problem with Order Import for ' . $country . ' Error : ' . $e->getMessage();
            }
            
        } else {
            $dbOrder = AmzOrder::where('company_id', $company_id)->where('amazon_order_id', $order->getAmazonOrderId())->first();
            if ($dbOrder && !empty($dbOrder)) {
                $dbOrder->order_status = 'Canceled';
                $dbOrder->save();
            }
        }
    }
    
    public function createUpdateCustomer($order, $customer, $address, $currency, $items, $company_id, $country)
    {
        $dbCustomer = Contact::where('company_id', $company_id)->where('email', $customer->getBuyerEmail())->first();
        if (! $dbCustomer || empty($dbCustomer)) {
            $dbCustomer = new Contact;
        }
        $dbCustomer->company_id = $company_id;
        $dbCustomer->type = 'customer';
        if ($customer->getBuyerName() && !empty($customer->getBuyerName())) {
            $dbCustomer->name = $customer->getBuyerName();
        } else {
            $dbCustomer->name = 'Amazon Customer';
        }
        $dbCustomer->email = $customer->getBuyerEmail();
        $dbCustomer->enabled = 1;
        $dbCustomer->created_from = 'Amazon API';
        $dbCustomer->currency_code = $currency;
        //dump($address->getShippingAddress());
        if ($address->getShippingAddress()) {
        if ($address->getShippingAddress()->getAddressLine1()) {
            $line1 = $address->getShippingAddress()->getAddressLine1() . '<br>';
        } else {
            $line1 = '';
        }
        if ($address->getShippingAddress()->getAddressLine2()) {
            $line2 = $address->getShippingAddress()->getAddressLine2() . '<br>';
        } else {
            $line2 = '';
        }
        if ($address->getShippingAddress()->getAddressLine3()) {
            $line3 = $address->getShippingAddress()->getAddressLine3() . '<br>';
        } else {
            $line3 = '';
        }
        if ($address->getShippingAddress()->getCity()) {
            $city = $address->getShippingAddress()->getCity() . '<br>';
        } else {
            $city = '';
        }
        if ($address->getShippingAddress()->getCounty()) {
            $county = $address->getShippingAddress()->getCounty() . '<br>';
        } else {
            $county = '';
        }
        if ($address->getShippingAddress()->getDistrict()) {
            $disctrict = $address->getShippingAddress()->getDistrict() . '<br>';
        } else {
            $disctrict = '';
        }
        if ($address->getShippingAddress()->getStateOrRegion()) {
            $state = $address->getShippingAddress()->getStateOrRegion() . '<br>';
        } else {
            $state = '';
        }
        if ($address->getShippingAddress()->getPostalCode()) {
            $zipcode = $address->getShippingAddress()->getPostalCode() . '<br>';
        } else {
            $zipcode = '';
        }
        if ($address->getShippingAddress()->getCountryCode()) {
            $countrycode = $address->getShippingAddress()->getCountryCode() . '<br>';
        } else {
            $countrycode = '';
        }
        if ($address->getShippingAddress()->getPhone()) {
            $phone = $address->getShippingAddress()->getPhone() . '<br>';
        } else {
            $phone = '';
        }
        $dbCustomer->address = $line1 . $line2 . $line3 . $city . $county . $disctrict . $state . $zipcode . $countrycode . $phone;
        }
        $dbCustomer->city = $city;
        $dbCustomer->zip_code = $zipcode;
        if ($countrycode == 'GB') {$dbCustomer->country = 'United Kingdom';}
        $dbCustomer->save();
        $transaction = $this->createUpdateInvOrder($dbCustomer, $order, $currency, $items, $company_id, $country);
    }

    public function createUpdateInvOrder($dbCustomer, $order, $currencyCode, $items, $company_id, $country)
    {
        $customer = Contact::where('company_id', $company_id)->where('email', $dbCustomer->email)->first();
        $currency = Currency::where('company_id', $company_id)->where('code', $currencyCode)->first();
        $dbTransaction = Transaction::where('company_id', $company_id)->where('contact_id', $customer->id)->first();
        if (!$dbTransaction && empty($dbTransaction)) {
            $dbTransaction = new Transaction;
        }
        $dbTransaction->company_id = $company_id;
        $dbTransaction->type = 'income';
        $dbTransaction->contact_id = $customer->id;
        $dbTransaction->currency_code = $currencyCode;
        $dbTransaction->currency_rate = $currency->rate;
        $dbTransaction->paid_at = date('Y-m-d h:i:s', strtotime($order->getPurchaseDate()));
        $dbTransaction->amount = $order->getOrderTotal()->getAmount();
        $dbTransaction->account_id = 2;
        $dbTransaction->category_id = 3;
        $dbTransaction->payment_method = 'offline-payments.amazon.3';
        $dbTransaction->reference = $order->getAmazonOrderId();
        $dbTransaction->created_from = 'API';
        $dbTransaction->save();
        $this->createUpdateAmzOrder($dbCustomer, $order, $dbTransaction->id, $currencyCode, $items, $company_id, $country);
    }

    public function createUpdateAmzOrder($dbCustomer, $order, $tId, $currencyCode, $items, $company_id, $country)
    {
        $amzOrder = AmzOrder::where('company_id', $company_id)->where('country', $country)->where('amazon_order_id', $order->getAmazonOrderId())->first();
        $newOrder = false;
        if (!$amzOrder) {
            $amzOrder = new AmzOrder;
            $newOrder = true;
        }
        $amzOrder->company_id = $company_id;
        $amzOrder->country = $country;
        $amzOrder->order_id = $tId;
        $amzOrder->items_shipped = $order->getNumberOfItemsShipped();
        $amzOrder->items_unshipped = $order->getNumberOfItemsUnshipped();
        $amzOrder->customer_id = $dbCustomer->id;
        $amzOrder->order_total = $order->getOrderTotal()->getAmount();
        $amzOrder->currency_code = $currencyCode;
        $amzOrder->fulfillment_channel = $order->getFulfillmentChannel();
        $amzOrder->payment_method = $order->getPaymentMethodDetails()[0];
        $amzOrder->marketplace = $order->getSalesChannel();
        $amzOrder->amazon_order_id = $order->getAmazonOrderId();
        $amzOrder->is_business_order = (bool) $order->getIsBusinessOrder();
        $amzOrder->earliest_ship_date = date('Y-m-d h:i:s', strtotime($order->getEarliestShipDate()));
        $amzOrder->latest_delivery_date = date('Y-m-d h:i:s', strtotime($order->getLatestDeliveryDate()));
        $amzOrder->last_update_date = date('Y-m-d h:i:s', strtotime($order->getLastUpdateDate()));
        $amzOrder->purchase_date = date('Y-m-d h:i:s', strtotime($order->getPurchaseDate()));
        $amzOrder->order_status = $order->getOrderStatus();
        $amzOrder->save();
        $orderId = $items->getAmazonOrderId();
        foreach ($items->getOrderItems() as $item) {
            $this->createUpdateAmzOrderItem($newOrder, $orderId, $item, $company_id, $country);
        }
    }

    public function createUpdateAmzOrderItem($newOrder, $orderId, $item, $company_id, $country)
    {
        $dbItem = AmzOrderItem::where('company_id', $company_id)->where('country', $country)->where('amazon_order_id', $orderId)->first();
        $amzItem = AmzItem::where('company_id', $company_id)->where('asin', $item->getAsin())->where('country', $country)->first();
        $amzOrder = AmzOrder::where('company_id', $company_id)->where('amazon_order_id', $orderId)->where('country', $country)->first();
        if ($amzOrder) {
            if ($amzOrder->asin_ids && (! str_contains($amzOrder->asin_ids, $item->getAsin()))) {
                $amzOrder->asin_ids .= ',' . $item->getAsin();
            } else {
                $amzOrder->asin_ids = $item->getAsin();
            }
            $amzOrder->save();
        }
        if ($newOrder == true) {
            $amzItem->quantity = $amzItem->quantity - $item->getQuantityOrdered();
        }
        $amzItem->save();
        if (!$dbItem) {
            $dbItem = new AmzOrderItem;
        }
        $dbItem->company_id = $company_id;
        $dbItem->country = $country;
        $dbItem->asin = $item->getAsin();
        $dbItem->order_id = $amzOrder->id;
        $dbItem->quantity = $item->getQuantityOrdered();
        $dbItem->amazon_order_item_id = $item->getOrderItemId();
        $dbItem->price = $item->getItemPrice()->getAmount();
        $dbItem->item_tax = $item->getItemTax()->getAmount();
        $dbItem->promotion_discount = $item->getPromotionDiscount()->getAmount();
        $dbItem->promotion_discount_tax = $item->getPromotionDiscountTax()->getAmount();
        $dbItem->amazon_order_id = $orderId;
        $dbItem->amazon_item_id = $amzItem->id;
        $dbItem->image = $amzItem->main_picture;
        $dbItem->sku = $amzItem->sku;
        $dbItem->save();
        //$this->updateDbItem($item, $amzItem);
    }

    

    public function getOrderBuyer($id, $config)
    {
        
        $apiInstance = new OrdersApi($config);
        $marketplace_ids = ['A1F83G8C2ARO7P'];
        try {
            return $apiInstance->getOrderBuyerInfo($id)->getPayload();
        } catch (Exception $e) {
            echo 'Exception when calling OrdersApi->getOrderAddress: ', $e->getMessage(), PHP_EOL;
        }

    }

    public function getOrderAddress($id, $config)
    {
        
        $apiInstance = new OrdersApi($config);
        try {
            return $apiInstance->getOrderAddress($id)->getPayload();
        } catch (Exception $e) {
            echo 'Exception when calling OrdersApi->getOrderAddress: ', $e->getMessage(), PHP_EOL;
        }

    }

    public function getOrderItems($id, $config)
    {
        
        $apiInstance = new OrdersApi($config);
        try {
            $items = $apiInstance->getOrderItems($id);
            return $items->getPayload();
        } catch (Exception $e) {
            echo 'Exception when calling OrdersApi->getOrderAddress: ', $e->getMessage(), PHP_EOL;
        }

    }

    public function updateDbItem($item, $amzItem)
    {
        $comItem = Item::where('id', $amzItem->item_id)->first();
        $comItem->quantity = $comItem->quantity - $item['QuantityOrdered'];
        $comItem->save();
    }
}
