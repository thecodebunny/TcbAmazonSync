<?php

namespace Modules\TcbAmazonSync\Models\Amazon;

use App\Abstracts\Model;
use Bkwld\Cloner\Cloneable;
use Modules\Inventory\Database\Factories\Item as ItemFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UkItem extends Model
{

    protected $table = 'amazon_uk_items';

    protected $fillable = [
        'id',
        'item_id',
        'com_item_id',
        'ean',
        'enable',
        'amazon_status',
        'asin',
        'sale_price',
        'sku',
        'title',
        'description',
        'asin',
        'quantity',
        'description',
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

    public function inventoryitem()
    {
        return $this->belongsTo('Modules\Inventory\Models\Item')->withDefault(['name' => trans('general.na')]);
    }

}