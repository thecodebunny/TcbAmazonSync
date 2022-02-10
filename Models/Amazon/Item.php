<?php

namespace Modules\TcbAmazonSync\Models\Amazon;

use App\Abstracts\Model;
use Bkwld\Cloner\Cloneable;
use App\Models\Banking\Transaction;
use Kyslik\ColumnSortable\Sortable;
use Modules\TcbAmazonSync\Models\Amazon\Warehouse;
use Modules\TcbAmazonSync\Models\Amazon\Issue;
use Modules\TcbAmazonSync\Models\Amazon\OrderItem;
use Modules\Inventory\Database\Factories\Item as ItemFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Item extends Model
{
    use Sortable;

    protected $table = 'amazon_items';

    public $sortable = [
        'id',
        'quantity',
        'price'
    ];

    protected $fillable = [
        'id',
        'company_id',
        'item_id',
        'country',
        'ean',
        'enable',
        'brand',
        'product_type',
        'keywords',
        'amazon_status',
        'asin',
        'packaging',
        'sale_price',
        'sku',
        'title',
        'description',
        'country_of_origin',
        'color',
        'quantity',
        'lead_time_to_ship_max_days',
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
        'size',
        'weight',
        'weight_measure',
        'length',
        'length_measure',
        'height',
        'height_measure',
        'width',
        'width_measure',
    ];

    public function item()
    {
        return $this->belongsTo('App\Models\Common\Item')->withDefault(['name' => trans('general.na')]);
    }

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class, 'id', 'warehouse');
    }

    public function issues()
    {
        return $this->hasMany(Issue::class, 'id', 'amz_item_id');
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