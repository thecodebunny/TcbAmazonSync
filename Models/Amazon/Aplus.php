<?php

namespace Modules\TcbAmazonSync\Models\Amazon;

use App\Abstracts\Model;
use Bkwld\Cloner\Cloneable;
use Modules\Inventory\Database\Factories\Item as ItemFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Aplus extends Model
{

    protected $table = 'amazon_aplus_content';

    protected $fillable = [
        'id',
        'item_id',
        'amz_item_id',
        'asin',
        'content_reference_key',
        'content_type',
        'content_sub_type'
    ];

}