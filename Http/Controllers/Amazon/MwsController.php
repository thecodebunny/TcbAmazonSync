<?php

namespace Modules\TcbAmazonSync\Http\Controllers\Amazon;

use App\Abstracts\Http\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Route;
use App\Models\Common\Item as BaseItem;
use App\Models\Common\Contact;
use Modules\TcbAmazonSync\Models\Amazon\Item as AmzItem;
use Modules\TcbAmazonSync\Models\Amazon\Asin as AmzAsin;
use Modules\TcbAmazonSync\Models\Amazon\Categories;
use Modules\TcbAmazonSync\Models\Amazon\SpApiSetting;
use Modules\TcbAmazonSync\Models\Amazon\MwsApiSetting;
//Amazon MWS API
use Thecodebunny\AmzMwsApi\AmazonOrderList;
use Thecodebunny\AmzMwsApi\AmazonProductList;
use Thecodebunny\AmzMwsApi\AmazonProductInfo;
use Thecodebunny\AmzMwsApi\AmazonOrderItemList;

class MwsController extends Controller
{
    private $config;
    private $company_id;
    private $country;
    private $settings;

    public function __construct(Request $request)
    {
        $this->country = Route::current()->originalParameter('country');
        $this->company_id = Route::current()->originalParameter('company_id');
        $this->settings = MwsApiSetting::where('company_id',Route::current()->originalParameter('company_id'))->first();
        if ($this->country = 'Uk') {
            $mp_id = 'A1F83G8C2ARO7P';
        }
        $this->config = [
            'merchantId' => $this->settings->merchant_id,
            'marketplaceId' => $mp_id,
            'keyId' => $this->settings->key_id,
            'secretKey' => $this->settings->secret_key,
            'amazonServiceUrl' => 'https://mws-eu.amazonservices.com/',
        ];
    }

    public function fetchAllProducts(Request $request)
    {
        
        $amz = new AmazonProductList($this->config);
        $allProducts = AmzAsin::all()->toArray();
        foreach ($allProducts as $product) {
            $amz->setProductIds($product['ean']);
            $amz->setIdType('EAN');
            $amzAsin = $amz->fetchProductList();
            $asin = $amzAsin['GetMatchingProductForIdResult'];
            $item = BaseItem::where('id', $product['item_id'])->first();
            //$this->addUpdateAsin($product['item_id'], $product['item_id'], $product['ean'], $asin);
            $this->updateAmazonItem($product['item_id'], $product['ean'], $asin);
        }
    }

    public function fetchAmazonItem(Request $request, $item_id, $ean, $asin)
    {
        $amz = new AmazonProductList($this->config);
        $amz->setProductIds($ean);
        $amz->setIdType('EAN');
        $amzAsin = $amz->fetchProductList();
        $asin = $amzAsin['GetMatchingProductForIdResult'];
        var_dump($asin);
        //$this->addUpdateAsin($item_id, $ean, $asin);
        $this->updateAmazonItem($item_id, $ean, $asin);
    }

    public function updateAmazonItem($item_id, $ean, $asin)
    {
        $dbItem = AmzItem::where('company_id', $this->company_id)->where('ean', $ean)->where('country', $this->country)->first();
        if (!$dbItem || empty($dbItem)) {
            $dbItem = new AmzItem;
        } 
        
        $dbItem->company_id = $this->company_id;
        $dbItem->enable = 'on';
        $dbItem->country = $this->country;
        $dbItem->item_id = $item_id;
        $dbItem->ean = $ean;
        echo '<pre>';
        error_log("ERROR: ASIN: ");
        error_log(var_dump($asin));
        $dbItem->brand = $asin['Products']['Product']['AttributeSets']['ItemAttributes']['Brand'];
        if (array_key_exists('Color', $asin['Products']['Product']['AttributeSets']['ItemAttributes'])) {
            $dbItem->color = $asin['Products']['Product']['AttributeSets']['ItemAttributes']['Color'];
        }
        if (array_key_exists('Size', $asin['Products']['Product']['AttributeSets']['ItemAttributes'])) {
            $dbItem->size = $asin['Products']['Product']['AttributeSets']['ItemAttributes']['Size'];
        }
        if (array_key_exists('MaterialType', $asin['Products']['Product']['AttributeSets']['ItemAttributes'])) {
            $dbItem->material = $asin['Products']['Product']['AttributeSets']['ItemAttributes']['MaterialType'];
        }
        $dbItem->title = str_replace('Zoomyo ','',str_replace('zoomyo ', '', $asin['Products']['Product']['AttributeSets']['ItemAttributes']['Title']));
        $dbItem->ean = $asin['@attributes']['Id'];
        $dbItem->asin = $asin['Products']['Product']['Identifiers']['MarketplaceASIN']['ASIN'];
        $dbItem->save();
    }

    public function addUpdateAsin($item_id, $ean, $asin)
    {
        $amazonItem = AmzAsin::where('ean', $ean)->first();
        if (! $amazonItem || empty($amazonItem)) {
            $amazonItem = new AmzAsin;
        }
        $amazonItem->company_id = $this->company_id;
        $amazonItem->ean = $ean;
        $amazonItem->item_id = $item_id;
        if ($this->country == 'Uk') {
            $amazonItem->uk_asin = $asin['Products']['Product']['Identifiers']['MarketplaceASIN']['ASIN'];
        }
        $amazonItem->save();
        $data = [
            'item_id' => $item_id,
            'ean'   => $ean,
            'asin' => $asin,
        ];
        echo '<pre>';
        var_dump($data);
    }

}