<?php

namespace Modules\TcbAmazonSync\Models\Amazon;

use App\Abstracts\Model;
use Bkwld\Cloner\Cloneable;
use Modules\Inventory\Database\Factories\Item as ItemFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\TcbAmazonSync\Models\Amazon\Order;
use Modules\TcbAmazonSync\Models\Amazon\Item;

class OrderItem extends Model
{

    protected $table = 'amazon_order_items';

    protected $fillable = [
        'id',
        'company_id',
        'item_id',
        'country',
        'image',
        'sku',
        'order_id',
        'amazon_order_id',
        'amazon_order_item_id',
        'quantity',
        'price',
        'currency_code',
        'promotion_discount',
        'promotion_discount_tax'
    ];

    public function order()
    {
        $this->belongsTo(Order::class, 'order_id');
    }

    public function amzitem()
    {
        $this->belongsTo(Item::class, 'amazon_item_id');
    }

}