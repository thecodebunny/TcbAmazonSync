<?php

namespace Modules\TcbAmazonSync\Models\Amazon;

use App\Abstracts\Model;
use Bkwld\Cloner\Cloneable;
use Modules\Inventory\Database\Factories\Item as ItemFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Asin extends Model
{

    protected $table = 'amazon_orders';

    protected $fillable = [
        'id',
        'asin_id',
        'item_id',
        'amazon_order_id',
        'customer_id',
        'company_id',
        'qty',
        'price',
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

}