<?php

namespace Modules\TcbAmazonSync\Http\Controllers\Amazon;

use App\Abstracts\Http\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Route;
use Modules\Inventory\Models\Item;
use Modules\Inventory\Models\Warehouse;
use Modules\TcbAmazonSync\Models\Amazon\Categories;
use Modules\TcbAmazonSync\Models\Amazon\SpApiSetting;
use Modules\TcbAmazonSync\Models\Amazon\MwsApiSetting;
//Amazon SP API
use Thecodebunny\SpApi\Configuration;
use Thecodebunny\SpApi\Endpoint;;
use Thecodebunny\SpApi\Api\OrdersApi;
use Thecodebunny\SpApi\Api\CatalogApi;

class SpController extends Controller
{

    private $config;

    public function __construct(Request $request)
    {
        $settings = SpApiSetting::where('company_id', Route::current()->originalParameter('company_id'))->first();
        $this->config = new Configuration([
            "lwaClientId" => $settings->client_id,
            "lwaClientSecret" => $settings->client_secret,
            "lwaRefreshToken" => $settings->eu_token,
            "awsAccessKeyId" => $settings->ias_access_key,
            "awsSecretAccessKey" => $settings->ias_access_token,
            // If you're not working in the North American marketplace, change
            // this to another endpoint from lib/Endpoint.php
            "endpoint" => Endpoint::EU,
            "roleArn" => $settings->iam_arn,
            "debug" => true,
            "debugFile" => '/var/www/go/storage/logs/spapi'
        ]);
    }

    public function getOrders(Request $request)
    {
        
        $apiInstance = new OrdersApi($this->config);
        $marketplace_ids = ['A1F83G8C2ARO7P'];
        $created_after = '2021-06-01';
        $created_before = '2021-11-30';
        $data_elements = [];
        $order_id = '205-9894695-8388318';
        try {
            $result = $apiInstance->getOrder(
                $order_id
            );
            dump($result);
            /*
            foreach ($result['payload']['orders'] as $order) {
                dump($order);
            }
            */

        } catch (Exception $e) {
            echo 'Exception when calling OrdersApi->getOrders: ', $e->getMessage(), PHP_EOL;
        }
    }

    public function getOrder($order_id, $settings)
    {
        
    }

    public function getAllItems(Request $request, $country)
    {
        if ($country == 'Uk') {
            $marketplace_id = 'A1F83G8C2ARO7P';
        }
        $itemModel = 'Modules\TcbAmazonSync\Models\Amazon\\'. $country .'Item';
        $items = $itemModel::where('company_id', Route::current()->originalParameter('company_id'))->all();
        dump($items);
        if (count($items)) {
            foreach ($items as $item) {
                $apiInstance = new CatalogApi($this->config);
                $result = $apiInstance->getCatalogItem($marketplace_id, $item->asin);
                dump( $result->getPayload()->getAttributeSets()[0]->getTitle());
            }
        }
    }

}