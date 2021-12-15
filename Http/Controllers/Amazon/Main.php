<?php

namespace Modules\TcbAmazonSync\Http\Controllers\Amazon;

use App\Abstracts\Http\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Inventory\Models\Item;
use Modules\Inventory\Models\Warehouse;
use Modules\TcbAmazonSync\Models\Amazon\Categories;
use Modules\TcbAmazonSync\Models\Amazon\SpApiSetting;
use Modules\TcbAmazonSync\Models\Amazon\MwsApiSetting;
//Amazon SP API
use Thecodebunny\AmazonSpApi\Configuration;
use Thecodebunny\AmazonSpApi\Api\CatalogApi;
use Thecodebunny\AmazonSpApi\SellingPartnerOAuth;
use Thecodebunny\AmazonSpApi\SellingPartnerRegion;
use Thecodebunny\AmazonSpApi\SellingPartnerEndpoint;
//Amazon MWS API
use Thecodebunny\AmzMwsApi\AmazonOrderList;

class Main extends Controller
{

    public function dashboard()
    {
        
    }

    public function asinform($item_id)
    {
        $item = Item::where('id', $item_id)->first();
        $inventory_item = Item::where('id', $item_id)->first();
        $mwsSettings = MwsApiSetting::first();
        $uk_item = \Modules\TcbAmazonSync\Models\Amazon\UkItem::where('item_id', $item_id)->first();
        $amz_item = \Modules\TcbAmazonSync\Models\Amazon\Item::where('inv_item_id', $item_id)->first();
        $ukCategories = Categories::get(['uk_node_id', 'node_path']);
        $warehouses = Warehouse::enabled()->pluck('name', 'id');

        return $this->response('tcb-amazon-sync::amazon.asins.edit', compact('item', 'inventory_item', 'uk_item', 'amz_item',  'mwsSettings', 'ukCategories', 'warehouses'));
    }

    public function getToken(Request $request)
    {
        $settings = SpApiSetting::where($request->input('company_id'))->first();

        $options = [
            'refresh_token' => $settings->eu_token, // Aztr|...
            'client_id' => $settings->client_id, // App ID from Seller Central, amzn1.sellerapps.app.cfbfac4a-......
            'client_secret' => $settings->client_secret, // The corresponding Client Secret
            'region' => SellingPartnerRegion::$EUROPE, // or NORTH_AMERICA / FAR_EAST
            'access_key' => $settings->ias_access_key, // Access Key of AWS IAM User, for example AKIAABCDJKEHFJDS
            'secret_key' => $settings->ias_access_token, // Secret Key of AWS IAM User
            'endpoint' => SellingPartnerEndpoint::$EUROPE, // or NORTH_AMERICA / FAR_EAST
        ];
        $accessToken = SellingPartnerOAuth::getAccessTokenFromRefreshToken(
            $options['refresh_token'],
            $options['client_id'],
            $options['client_secret']
        );
        $config = Configuration::getDefaultConfiguration();
        $config->setHost($options['endpoint']);
        $config->setAccessToken($accessToken);
        $config->setAccessKey($options['access_key']);
        $config->setSecretKey($options['secret_key']);
        $config->setRegion($options['region']);
        $apiInstance = new CatalogApi($config);
        $marketplace_id = 'A1PA6795UKMFR9';
        $asin = 'B0002ZFTJA';

        $result = $apiInstance->getCatalogItem($marketplace_id, $asin);
        echo $result->getPayload()->getAttributeSets()[0]->getTitle();
        echo '<pre>';
        var_dump($result);

    }

    public function testMws(Request $request)
    {
        $settings = MwsApiSetting::where($request->input('company_id'))->first();
        $config = [
            'merchantId' => $settings->merchant_id,
            'marketplaceId' => 'A1PA6795UKMFR9',
            'keyId' => $settings->key_id,
            'secretKey' => $settings->secret_key,
            'amazonServiceUrl' => 'https://mws-eu.amazonservices.com/',
        ];
        $amz = new AmazonOrderList($config);
        $orders = $amz->fetchOrders();

        echo '<pre class="prettyprint linenums">
            <code class="language-xml">' . ($orders) . '</code>
        </pre>';
        //var_dump($amz);
        //var_dump(($orders));
    }

}