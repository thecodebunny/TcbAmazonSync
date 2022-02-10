<?php

namespace Modules\TcbAmazonSync\Http\Controllers\Amazon;

use App\Abstracts\Http\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Common\Item;
use App\Models\Common\Company;
use App\Models\Common\Contact;
use App\Models\Setting\Currency;
use App\Models\Banking\Transaction;
use Illuminate\Support\Facades\Route;
use Modules\TcbAmazonSync\Models\Amazon\SpApiSetting;
use Modules\TcbAmazonSync\Models\Amazon\MwsApiSetting;
use Modules\TcbAmazonSync\Http\Controllers\Amazon\SpApi;
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
    private $request;
    private $spApi;
    private $config;
    private $company_id;
    private $country;
    private $settings;

    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->spApi = new SpApi($this->request);
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
        $orders = AmzOrder::with('items', 'contact')->sortable()->orderBy('created_at', 'desc')->paginate(50);
        return view('tcb-amazon-sync::amazon.orders.index', compact('orders'));
    }

    public function show($id)
    {
        $order = AmzOrder::where('id', $id)->with('items', 'contact')->first();
        $company = Company::where('id', $order->company_id)->first();
        $relatedOrders = AmzOrder::where('customer_id', $order->customer_id)->sortable()->get();
        $asins = [];
        foreach ($order->items as $i => $item) {
            $asins[$i] = AmzItem::where('id', $item->amazon_item_id)->first();
        }
        return view('tcb-amazon-sync::amazon.orders.show', compact('order', 'company', 'relatedOrders', 'asins'));
    }

    public function edit($id)
    {
        $order = AmzOrder::where('id', $id)->with('items', 'contact')->first();
        return view('tcb-amazon-sync::amazon.orders.edit', compact('order'));
    }

    public function getOrders()
    {
        $orders = $this->spApi->getOrders($this->request);
        $this->createOrders($orders);
    }

    public function createOrders($orders)
    {
        foreach ($orders as $order) {
            //sleep(30);
            $this->createDbOrder($order);
        }
    }
    
    public function createDbOrder($order)
    {
        if ($order->getOrderStatus() !== 'Canceled') {
            $customer = $this->spApi->getOrderBuyer($order->getAmazonOrderId(), $this->request);
            $address = $this->spApi->getOrderAddress($order->getAmazonOrderId(), $this->request);
            $items = $this->spApi->getOrderItems($order->getAmazonOrderId(), $this->request);
            $currency = $order->getOrderTotal()->getCurrencyCode();
            dump($order);
            $this->createUpdateCustomer($order, $customer, $address, $currency, $items);
            
        } else {
            $dbOrder = AmzOrder::where('company_id', $this->company_id)->where('amazon_order_id', $order->getAmazonOrderId())->first();
            if ($dbOrder && !empty($dbOrder)) {
                $dbOrder->order_status = 'Canceled';
            }
        }
    }
    
    public function createUpdateCustomer($order, $customer, $address, $currency, $items)
    {
        $dbCustomer = Contact::where('company_id', $this->company_id)->where('email', $customer->getBuyerEmail())->first();
        if (! $dbCustomer || empty($dbCustomer)) {
            $dbCustomer = new Contact;
        }
        $dbCustomer->company_id = $this->company_id;
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
        dump($address->getShippingAddress());
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
        $dbCustomer->city = $city;
        $dbCustomer->zip_code = $zipcode;
        if ($countrycode == 'GB') {$dbCustomer->country = 'United Kingdom';}
        $dbCustomer->save();
        $transaction = $this->createUpdateInvOrder($dbCustomer, $order, $currency, $items);
    }

    public function createUpdateInvOrder($dbCustomer, $order, $currencyCode, $items)
    {
        $customer = Contact::where('company_id', $this->company_id)->where('email', $dbCustomer->email)->first();
        $currency = Currency::where('company_id', $this->company_id)->where('code', $currencyCode)->first();
        $dbTransaction = Transaction::where('company_id', $this->company_id)->where('contact_id', $customer->id)->first();
        if (!$dbTransaction && empty($dbTransaction)) {
            $dbTransaction = new Transaction;
        }
        $dbTransaction->company_id = $this->company_id;
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
        $this->createUpdateAmzOrder($dbCustomer, $order, $dbTransaction->id, $currencyCode, $items);
    }

    public function createUpdateAmzOrder($dbCustomer, $order, $tId, $currencyCode, $items)
    {
        $amzOrder = AmzOrder::where('company_id', $this->company_id)->where('country', $this->country)->where('amazon_order_id', $order->getAmazonOrderId())->first();
        $newOrder = false;
        if (!$amzOrder) {
            $amzOrder = new AmzOrder;
            $newOrder = true;
        }
        $amzOrder->company_id = $this->company_id;
        $amzOrder->country = $this->country;
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
            $this->createUpdateAmzOrderItem($newOrder, $orderId, $item);
        }
    }

    public function createUpdateAmzOrderItem($newOrder, $orderId, $item)
    {
        $dbItem = AmzOrderItem::where('company_id', $this->company_id)->where('country', $this->country)->where('amazon_order_id', $orderId)->first();
        $amzItem = AmzItem::where('company_id', $this->company_id)->where('asin', $item->getAsin())->where('country', $this->country)->first();
        $amzOrder = AmzOrder::where('company_id', $this->company_id)->where('amazon_order_id', $orderId)->where('country', $this->country)->first();
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
        $dbItem->company_id = $this->company_id;
        $dbItem->country = $this->country;
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
        $this->updateDbItem($item, $amzItem);
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

    public function toRemove()
    {
        $items = AmzOrderItem::all();
        foreach($items as $item) {
            $amzItem = AmzItem::where('id', $item->amazon_item_id)->first();
            $dbItem = AmzOrderItem::where('id', $item->id)->first();
            //dump($amzItem);
            $dbItem->image = $amzItem->main_picture;
            $dbItem->sku = $amzItem->sku;
            $dbItem->save();
        }
    }

}