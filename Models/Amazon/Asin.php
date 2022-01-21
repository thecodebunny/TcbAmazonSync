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
        'uk_asin',
        'de_asin',
        'fr_asin',
        'it_asin',
        'es_asin',
        'se_asin',
        'nl_asin',
        'pl_asin',
        'in_asin',
        'us_asin',
        'mx_asin',
        'ca_asin'
    ];

}