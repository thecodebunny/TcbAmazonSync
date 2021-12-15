<?php

namespace Modules\TcbAmazonSync\Models\Amazon;

use App\Abstracts\Model;
use Bkwld\Cloner\Cloneable;
use Modules\Inventory\Database\Factories\Item as ItemFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Categories extends Model
{

    protected $table = 'amazon_categories';

    protected $fillable = [
        'id',
        'root_node',
        'uk_node_id',
        'node_path',
        'de_node_id',
        'fr_node_id',
        'it_node_id',
        'es_node_id'
    ];

}