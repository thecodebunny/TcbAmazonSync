<?php

namespace Modules\TcbAmazonSync\Models\Amazon;

use App\Abstracts\Model;
use Bkwld\Cloner\Cloneable;
use Modules\Inventory\Database\Factories\Item as ItemFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Report extends Model
{

    protected $table = 'amazon_reports';

    protected $fillable = [
        'id',
        'status'
    ];

}