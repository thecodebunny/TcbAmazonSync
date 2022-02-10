<?php

namespace Modules\TcbAmazonSync\Models\Amazon;

use App\Abstracts\Model;
use Bkwld\Cloner\Cloneable;
use Modules\Inventory\Database\Factories\Item as ItemFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductType extends Model
{

    protected $table = 'amazon_product_types';

    protected $fillable = [
        'id',
        'name',
        'is_uk',
        'is_de',
        'is_fr',
        'is_it',
        'is_es',
        'is_se',
        'is_nl',
        'is_pl',
        'is_us',
        'is_ca'
    ];

}