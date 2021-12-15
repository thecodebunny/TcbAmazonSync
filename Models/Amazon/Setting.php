<?php

namespace Modules\TcbAmazonSync\Models\Amazon;

use App\Abstracts\Model;
use Bkwld\Cloner\Cloneable;
use Modules\Inventory\Database\Factories\Item as ItemFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Setting extends Model
{

    protected $table = 'amazon_settings';

    protected $fillable = [
        'id',
        'company_id',
        'default_warehouse'
    ];

}