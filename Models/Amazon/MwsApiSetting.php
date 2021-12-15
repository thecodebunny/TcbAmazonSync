<?php

namespace Modules\TcbAmazonSync\Models\Amazon;

use App\Abstracts\Model;
use Bkwld\Cloner\Cloneable;
use Modules\Inventory\Database\Factories\Item as ItemFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MwsApiSetting extends Model
{

    protected $table = 'amazon_mws_api_settings';

    protected $fillable = [
        'id',
        'company_id',
        'merchant_id',
        'key_id',
        'secret_key',
        'auth_token'
    ];

}