<?php

namespace Modules\TcbAmazonSync\Models\Amazon;

use App\Abstracts\Model;
use Bkwld\Cloner\Cloneable;
use Modules\Inventory\Database\Factories\Item as ItemFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SpApiSetting extends Model
{

    protected $table = 'amazon_sp_api_settings';

    protected $fillable = [
        'id',
        'company_id',
        'app_name',
        'client_id',
        'client_secret',
        'eu_token',
        'us_token',
        'ias_access_key',
        'ias_access_token',
        'endpoint',
        'iam_arn'
    ];

}