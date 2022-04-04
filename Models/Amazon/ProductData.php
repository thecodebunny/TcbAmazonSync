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

    protected $table = 'amazon_product_data';

    public $sortable = [
        'id',
        'name'
    ];



}