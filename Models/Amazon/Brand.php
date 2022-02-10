<?php

namespace Modules\TcbAmazonSync\Models\Amazon;

use App\Abstracts\Model;
use Bkwld\Cloner\Cloneable;
use Modules\Inventory\Database\Factories\Item as ItemFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Brand extends Model
{

    protected $table = 'amazon_brands';

    protected $fillable = [
        'id',
        'company_id',
        'name',
        'enabled',
        'default_brand'
    ];

}