<?php

namespace Modules\TcbAmazonSync\Models\Amazon;

use App\Abstracts\Model;
use App\Models\Banking\Transaction;
use Modules\TcbAmazonSync\Models\Warehouse;
use Modules\TcbAmazonSync\Models\Amazon\OrderItem;
use Bkwld\Cloner\Cloneable;
use Modules\Inventory\Database\Factories\Item as ItemFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Item extends Model
{

    protected $table = 'amazon_items';

    protected $fillable = [
        'id',
        'company_id',
        'item_id',
        'country',
        'ean',
        'enable',
        'brand',
        'amazon_status',
        'asin',
        'sale_price',
        'sku',
        'title',
        'description',
        'color',
        'quantity',
        'size',
        'price',
        'category_id',
        'main_picture',
        'picture_1',
        'picture_2',
        'picture_3',
        'picture_4',
        'picture_5',
        'picture_6',
        'bullet_point_1',
        'bullet_point_2',
        'bullet_point_3',
        'bullet_point_4',
        'bullet_point_5',
        'bullet_point_6',
    ];

    public function item()
    {
        return $this->belongsTo('App\Models\Common\Item')->withDefault(['name' => trans('general.na')]);
    }

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class, 'id', 'warehouse');
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);        
    }

    public function orderitems()
    {
        return $this->hasMany(OrderItem::class);
    }

}