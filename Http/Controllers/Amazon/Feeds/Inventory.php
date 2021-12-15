<?php

namespace Modules\TcbAmazonSync\Http\Controllers\Amazon;

use DB;
use App\Abstracts\Http\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Route;
use Modules\TcbAmazonSync\Models\Amazon\SpApiSetting;
use Modules\TcbAmazonSync\Models\Amazon\MwsApiSetting;
use Modules\TcbAmazonSync\Models\Amazon\Report;
use Illuminate\Support\Facades\Storage;
//Amazon SP API
use Thecodebunny\AmazonSpApi\Configuration;
use Thecodebunny\AmazonSpApi\Api\CatalogApi;
use Thecodebunny\AmazonSpApi\SellingPartnerOAuth;
use Thecodebunny\AmazonSpApi\SellingPartnerRegion;
use Thecodebunny\AmazonSpApi\SellingPartnerEndpoint;
//Amazon MWS API
use Thecodebunny\AmzMwsApi\AmazonReport;
use Thecodebunny\AmzMwsApi\AmazonReportRequest;
use Thecodebunny\AmzMwsApi\AmazonReportRequestList;
use Thecodebunny\AmzMwsApi\AmazonInventoryList;

class Inventory extends Controller
{

    private $config;

    public function __construct(Request $request)
    {
        $settings = MwsApiSetting::where('company_id', Route::current()->parameter('company_id'))->first();
        $this->config = [
            'merchantId' => $settings->merchant_id,
            'marketplaceId' => 'A1PA6795UKMFR9',
            'keyId' => $settings->key_id,
            'secretKey' => $settings->secret_key,
            'amazonServiceUrl' => 'https://mws-eu.amazonservices.com/',
        ];
    }

}