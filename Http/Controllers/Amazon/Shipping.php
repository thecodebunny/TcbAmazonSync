<?php

namespace Modules\TcbAmazonSync\Http\Controllers\Amazon;

use App\Abstracts\Http\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Common\Item;
use App\Models\Common\Company;
use App\Models\Common\Contact;
use App\Models\Setting\Currency;
use App\Models\Banking\Transaction;
use Illuminate\Support\Facades\Route;
use Modules\TcbAmazonSync\Models\Amazon\SpApiSetting;
use Modules\TcbAmazonSync\Models\Amazon\Item as AmzItem;
use Modules\TcbAmazonSync\Models\Amazon\Asin as AmzAsin;
use Modules\TcbAmazonSync\Models\Amazon\Order as AmzOrder;
use Modules\TcbAmazonSync\Models\Amazon\OrderItem as AmzOrderItem;
//Amazon SP API
use Thecodebunny\SpApi\Endpoint;
use Thecodebunny\SpApi\FeedType;
use Thecodebunny\SpApi\Document;
use Thecodebunny\SpApi\Api\FeedsApi;
use Thecodebunny\SpApi\Configuration;
use Thecodebunny\SpApi\Api\ShippingApi;
use Thecodebunny\SpApi\Model\Shipping\GetRatesRequest;

class Shipping extends Controller
{
    private $country;
    private $config;
    private $settings;
    private $companyId;

    public function __construct(Request $request)
    {
        $this->country = Route::current()->originalParameter('country');
        $this->companyId = Route::current()->originalParameter('company_id');
        $this->settings = SpApiSetting::where('company_id',$this->companyId )->first();
        if ($this->country == 'Uk') {
            $endpoint = Endpoint::EU;
        }
        $this->config = new Configuration([
            "lwaClientId" => $this->settings->client_id,
            "lwaClientSecret" => $this->settings->client_secret,
            "lwaRefreshToken" => $this->settings->eu_token,
            "awsAccessKeyId" => $this->settings->ias_access_key,
            "awsSecretAccessKey" => $this->settings->ias_access_token,
            "endpoint" => Endpoint::EU,
            "roleArn" => $this->settings->iam_arn
        ]);
        $this->config->setDebug(false);
        $this->config->setDebugFile('/var/www/go/storage/logs/spapi.log');
    }

    public function getRates($id)
    {
        $apiInstance = new ShippingApi($this->config);
        $body = new GetRatesRequest;
        $order = AmzOrder::where('id', $id)->first();
        dump($order);
        
    }

}