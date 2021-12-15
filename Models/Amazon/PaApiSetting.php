<?php

namespace Modules\TcbAmazonSync\Models\Amazon;

use App\Abstracts\Model;
use Bkwld\Cloner\Cloneable;
use Modules\Inventory\Database\Factories\Item as ItemFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PaApiSetting extends Model
{

    protected $table = 'amazon_pa_api_settings';

    protected $fillable = [
        'id',
        'company_id',
        'api_key',
        'api_secret_key',
        'associate_tag_uk',
        'associate_tag_de',
        'associate_tag_fr',
        'associate_tag_it',
        'associate_tag_es',
        'associate_tag_se',
        'associate_tag_pl',
        'associate_tag_nl',
        'de',
        'fr',
        'it',
        'es',
        'se',
        'uk',
        'pl',
        'nl'
    ];

}