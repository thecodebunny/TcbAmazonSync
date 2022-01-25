<?php

namespace Modules\TcbAmazonSync\Models\Amazon;

use App\Abstracts\Model;
use Bkwld\Cloner\Cloneable;
use Modules\Inventory\Database\Factories\Item as ItemFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Feed extends Model
{

    protected $table = 'amazon_feeds';

    protected $fillable = [
        'id',
        'feed_type',
        'feed_document_id',
        'report_type',
        'request_id',
        'generated_report_id',
        'status',
        'api_type'
    ];

}