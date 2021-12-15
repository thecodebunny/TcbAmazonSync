<?php

namespace Modules\TcbAmazonSync\Models\Amazon;

use App\Abstracts\Model;
use Bkwld\Cloner\Cloneable;
use Modules\Inventory\Database\Factories\Item as ItemFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Asin extends Model
{

    protected $table = 'amazon_asins';

    protected $fillable = [
        'id',
        'item_id',
        'ean',
        'amazon_sale_price',
        'amazon_sku',
        'amazon_title',
        'amazon_description',
        'amazon_asin',
        'amazon_quantity',
        'amazon_description',
        'amazon_price',
        'amazon_category',
    ];

}