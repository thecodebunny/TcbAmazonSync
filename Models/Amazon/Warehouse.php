<?php

namespace Modules\TcbAmazonSync\Models\Amazon;

use App\Abstracts\Model;
use Bkwld\Cloner\Cloneable;
use Modules\TcbAmazonSync\Models\Amazon\Item;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Warehouse extends Model
{

    protected $table = 'amazon_warehouses';

    protected $fillable = [
        'id',
        'name',
        'street_1',
        'street_2',
        'postcode',
        'city',
        'country',
        'default'
    ];

    public function items()
    {
        return $this->hasMany(Item::class, 'warehouse');
    }

}