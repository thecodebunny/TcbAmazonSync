<?php

namespace Modules\TcbAmazonSync\Http\Controllers\Amazon;

use App\Abstracts\Http\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Common\Item;
use App\Models\Common\Contact;
use App\Models\Setting\Currency;
use App\Models\Banking\Transaction;
use Illuminate\Support\Facades\Route;
use Modules\TcbAmazonSync\Models\Amazon\SpApiSetting;
use Modules\TcbAmazonSync\Models\Amazon\MwsApiSetting;
use Modules\TcbAmazonSync\Models\Amazon\Item as AmzItem;
use Modules\TcbAmazonSync\Models\Amazon\Asin as AmzAsin;
use Modules\TcbAmazonSync\Models\Amazon\Order as AmzOrder;
use Modules\TcbAmazonSync\Models\Amazon\OrderItem as AmzOrderItem;
//Amazon SP API
use Thecodebunny\AmazonSpApi\Configuration;
use Thecodebunny\AmazonSpApi\Api\CatalogApi;
use Thecodebunny\AmazonSpApi\SellingPartnerOAuth;
use Thecodebunny\AmazonSpApi\SellingPartnerRegion;
use Thecodebunny\AmazonSpApi\SellingPartnerEndpoint;
//Amazon MWS API
use Thecodebunny\AmzMwsApi\AmazonOrderList;
use Thecodebunny\AmzMwsApi\AmazonProductList;
use Thecodebunny\AmzMwsApi\AmazonProductInfo;
use Thecodebunny\AmzMwsApi\AmazonOrderItemList;

class Orders extends Controller
{
    private $config;
    private $company_id;
    private $country;
    private $settings;

    public function __construct(Request $request)
    {
        $this->country = Route::current()->originalParameter('country');
        $this->company_id = Route::current()->originalParameter('company_id');
        $this->settings = MwsApiSetting::where('company_id',Route::current()->originalParameter('company_id'))->first();
        if ($this->country = 'Uk') {
            $mp_id = 'A1F83G8C2ARO7P';
        }
        $this->config = [
            'merchantId' => $this->settings->merchant_id,
            'marketplaceId' => $mp_id,
            'keyId' => $this->settings->key_id,
            'secretKey' => $this->settings->secret_key,
            'amazonServiceUrl' => 'https://mws-eu.amazonservices.com/',
        ];
    }

    public function index()
    {
        $orders = AmzOrder::with('items', 'contact')->paginate(50);
        return view('tcb-amazon-sync::amazon.orders.index', compact('orders'));
    }

    public function show()
    {

    }

    public function mwsOrdersRequest(Request $request)
    {
        $settings = MwsApiSetting::where(Route::current()->originalParameter('company_id'))->first();
        $config = [
            'merchantId' => $settings->merchant_id,
            'marketplaceId' => 'A1PA6795UKMFR9',
            'keyId' => $settings->key_id,
            'secretKey' => $settings->secret_key,
            'amazonServiceUrl' => 'https://mws-eu.amazonservices.com/',
        ];
        $amz = new AmazonOrderList($config);
        $orders = $amz->fetchOrders();

        echo '<pre class="prettyprint linenums">
            <code class="language-xml">' . ($orders) . '</code>
        </pre>';
        //var_dump($amz);
        //var_dump(($orders));
    }

    public function getOrders()
    {
        $amz = new AmazonOrderList($this->config);
        $amz->setLimits('Created', '-30 days');
        $ordersList = $amz->fetchOrders();
        if ($ordersList['ListOrdersResult']['Orders'] && !empty($ordersList['ListOrdersResult']['Orders'])) {
            $this->createOrders($ordersList['ListOrdersResult']['Orders']['Order']);
        }
    }

    public function createOrders($orders)
    {
        if (count($orders) > 1) {
            foreach ($orders as $order) {
                $this->createDbOrder($order);
            }
        } else {
            $this->createDbOrder($orders);
        }
    }
    
    public function createDbOrder($order)
    {
        if ($order['OrderStatus'] !== 'Canceled') {
            $this->createUpdateCustomer($order);
            
        } else {
            $dbOrder = AmzOrder::where('company_id', $this->company_id)->where('amazon_order_id', $order['AmazonOrderId'])->first();
            if ($dbOrder && !empty($dbOrder)) {
                $dbOrder->order_status = 'Canceled';
            }
        }
    }
    
    public function createUpdateCustomer($order)
    {
        $dbCustomer = Contact::where('company_id', $this->company_id)->where('email', $order['BuyerEmail'])->first();
        if (! $dbCustomer || empty($dbCustomer)) {
            $dbCustomer = new Contact;
        }
        $dbCustomer->company_id = $this->company_id;
        $dbCustomer->type = 'customer';
        if (array_key_exists('BuyerName', $order)) {
            $dbCustomer->name = $order['BuyerName'];
        } else {
            $dbCustomer->name = 'Amazon Customer';
        }
        $dbCustomer->email = $order['BuyerEmail'];
        $dbCustomer->enabled = 1;
        $dbCustomer->created_from = 'Amazon API';
        $dbCustomer->currency_code = $order['OrderTotal']['CurrencyCode'];
        $dbCustomer->address = $order['ShippingAddress']['City'] . ',</br>' . $order['ShippingAddress']['City'] . ', </br>' . $order['ShippingAddress']['PostalCode'] . ', </br>' . $order['ShippingAddress']['CountryCode'];
        $dbCustomer->city = $order['ShippingAddress']['City'];
        $dbCustomer->zip_code = $order['ShippingAddress']['PostalCode'];
        if ($order['ShippingAddress']['CountryCode'] == 'GB') {$dbCustomer->country = 'United Kingdom';}
        $dbCustomer->zip_code = $order['ShippingAddress']['PostalCode'];
        $dbCustomer->save();
        $transaction = $this->createUpdateInvOrder($dbCustomer, $order);
        //dump($dbCustomer);
    }

    public function createUpdateInvOrder($dbCustomer, $order)
    {
        $customer = Contact::where('company_id', $this->company_id)->where('email', $dbCustomer->email)->first();
        $currency = Currency::where('company_id', $this->company_id)->where('code', $order['OrderTotal']['CurrencyCode'])->first();
        $dbTransaction = Transaction::where('company_id', $this->company_id)->where('contact_id', $customer->id)->first();
        if (!$dbTransaction && empty($dbTransaction)) {
            $dbTransaction = new Transaction;
        }
        $dbTransaction->company_id = $this->company_id;
        $dbTransaction->type = 'income';
        $dbTransaction->contact_id = $customer->id;
        $dbTransaction->currency_code = $order['OrderTotal']['CurrencyCode'];
        $dbTransaction->currency_rate = $currency->rate;
        $dbTransaction->paid_at = date('Y-m-d h:i:s', strtotime($order['PurchaseDate']));
        $dbTransaction->amount = $order['OrderTotal']['Amount'];
        $dbTransaction->account_id = 2;
        $dbTransaction->category_id = 3;
        $dbTransaction->payment_method = 'offline-payments.amazon.3';
        $dbTransaction->reference = $order['AmazonOrderId'];
        $dbTransaction->created_from = 'API';
        $dbTransaction->save();
        $this->createUpdateAmzOrder($dbCustomer, $order, $dbTransaction->id);
    }

    public function createUpdateAmzOrder($dbCustomer, $order, $tId)
    {
        $amzOrder = AmzOrder::where('company_id', $this->company_id)->where('country', $this->country)->where('amazon_order_id', $order['AmazonOrderId'])->first();
        $newOrder = false;
        if (!$amzOrder) {
            $amzOrder = new AmzOrder;
            $newOrder = true;
        }
        $amzOrder->company_id = $this->company_id;
        $amzOrder->country = $this->country;
        $amzOrder->order_id = $tId;
        $amzOrder->items_shipped = $order['NumberOfItemsShipped'];
        $amzOrder->items_unshipped = $order['NumberOfItemsUnshipped'];
        $amzOrder->customer_id = $dbCustomer->id;
        $amzOrder->order_total = $order['OrderTotal']['Amount'];
        $amzOrder->currency_code = $order['OrderTotal']['CurrencyCode'];
        $amzOrder->fulfillment_channel = $order['FulfillmentChannel'];
        $amzOrder->payment_method = $order['PaymentMethodDetails']['PaymentMethodDetail'];
        $amzOrder->marketplace = $order['SalesChannel'];
        $amzOrder->amazon_order_id = $order['AmazonOrderId'];
        $amzOrder->earliest_ship_date = $order['EarliestShipDate'];
        $amzOrder->is_business_order = (bool) $order['IsBusinessOrder'];
        $amzOrder->earliest_ship_date = date('Y-m-d h:i:s', strtotime($order['EarliestShipDate']));
        $amzOrder->latest_delivery_date = date('Y-m-d h:i:s', strtotime($order['LatestDeliveryDate']));
        $amzOrder->last_update_date = date('Y-m-d h:i:s', strtotime($order['LastUpdateDate']));
        $amzOrder->purchase_date = date('Y-m-d h:i:s', strtotime($order['PurchaseDate']));
        $amzOrder->order_status = $order['OrderStatus'];
        $amzOrder->save();
        $amz = new AmazonOrderItemList($this->config);
            $amz->setOrderId($order['AmazonOrderId']);
            $amzOrderItems = $amz->fetchItems();
            if ($amzOrderItems['ListOrderItemsResult']['OrderItems'] && !empty($amzOrderItems['ListOrderItemsResult']['OrderItems'])) {
                $items = $amzOrderItems['ListOrderItemsResult']['OrderItems'];
                $orderId = $amzOrderItems['ListOrderItemsResult']['AmazonOrderId'];
                if (count($items) > 1) {
                    foreach ($items as $item) {
                        $this->createUpdateAmzOrderItem($newOrder, $orderId, $item);
                    }
                } else {
                    $this->createUpdateAmzOrderItem($newOrder, $orderId, $items);
                }
            }
            //dump($order);
    }

    public function createUpdateAmzOrderItem($newOrder, $orderId, $item)
    {
        $item = $item['OrderItem'];
        $dbItem = AmzOrderItem::where('company_id', $this->company_id)->where('country', $this->country)->where('amazon_order_id', $orderId)->first();
        $amzItem = AmzItem::where('company_id', $this->company_id)->where('asin', $item['ASIN'])->where('country', $this->country)->first();
        $amzOrder = AmzOrder::where('company_id', $this->company_id)->where('amazon_order_id', $orderId)->where('country', $this->country)->first();
        if ($amzOrder) {
            if ($amzOrder->asin_ids && !empty($amzOrder->asin_ids) && !strpos($amzOrder->asin_ids, $item['ASIN'])) {
                $amzOrder->asin_ids .= ',' . $item['ASIN'];
            } else {
                $amzOrder->asin_ids = $item['ASIN'];
            }
            $amzOrder->save();
        }
        if ($newOrder == true) {
            $amzItem->quantity = $amzItem->quantity - $item['QuantityOrdered'];
        }
        $amzItem->save();
        if (!$dbItem) {
            $dbItem = new AmzOrderItem;
        }
        $dbItem->company_id = $this->company_id;
        $dbItem->country = $this->country;
        $dbItem->asin = $item['ASIN'];
        $dbItem->order_id = $amzOrder->id;
        $dbItem->quantity = $item['QuantityOrdered'];
        $dbItem->amazon_order_item_id = $item['OrderItemId'];
        $dbItem->quantity = $item['QuantityOrdered'];
        $dbItem->price = $item['ItemPrice']['Amount'];
        $dbItem->amazon_order_id = $orderId;
        $dbItem->amazon_item_id = $amzItem->id;
        $dbItem->save();
        $this->updateDbItem($item, $amzItem);
        //dump($item);
    }

    public function createUpdateInvoiceItem($item)
    {
        
    }

    public function updateDbItem($item, $amzItem)
    {
        $comItem = Item::where('id', $amzItem->item_id)->first();
        $comItem->quantity = $comItem->quantity - $item['QuantityOrdered'];
        $comItem->save();
    }

}