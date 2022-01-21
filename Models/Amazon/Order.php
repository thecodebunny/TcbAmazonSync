<?php

namespace Modules\TcbAmazonSync\Models\Amazon;

use App\Abstracts\Model;
use Bkwld\Cloner\Cloneable;
use Modules\Inventory\Database\Factories\Item as ItemFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\TcbAmazonSync\Models\Amazon\OrderItem;
use App\Models\Banking\Transaction;
use App\Models\Common\Contact;

class Order extends Model
{

    protected $table = 'amazon_orders';

    protected $fillable = [
        'id',
        'asin_ids',
        'order_id',
        'amazon_order_id',
        'customer_id',
        'company_id',
        'items_shipped',
        'items_unshipped',
        'order_total',
        'fulfillment_channel',
        'payment_method',
        'marketplace',
        'earliest_ship_date',
        'latest_ship_date',
        'earliest_delivery_date',
        'latest_delivery_date',
        'last_update_date',
        'is_business_order',
        'purchase_date',
        'order_status',
        'sales_channel',
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'order_id');
    }

    public function contact()
    {
        return $this->belongsTo(Contact::class, 'customer_id');
    }

}