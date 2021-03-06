<?php

namespace Modules\TcbAmazonSync\Models\Amazon;

use App\Abstracts\Model;
use Bkwld\Cloner\Cloneable;
use Modules\TcbAmazonSync\Models\Amazon\Item;
use Modules\Inventory\Database\Factories\Item as ItemFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Issue extends Model
{

    protected $table = 'amazon_issues';

    protected $fillable = [
        'id',
        'item_id',
        'amz_item_id',
        'code',
        'message',
        'severity',
        'attribute_names'
    ];

    public function item()
    {
        return $this->belongsTo(Item::class, 'item_id');
    }

}