<?php

namespace Modules\TcbAmazonSync\Http\Controllers\Amazon;

use App\Abstracts\Http\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Common\Item as BaseItem;
use Modules\Inventory\Models\Item;
use Modules\Inventory\Models\Warehouse;
use Modules\TcbAmazonSync\Models\Amazon\Item as AmzItem;
use Modules\TcbAmazonSync\Models\Amazon\Categories;
use Modules\TcbAmazonSync\Models\Amazon\SpApiSetting;
use Modules\TcbAmazonSync\Models\Amazon\MwsApiSetting;
//Amazon MWS API
use Thecodebunny\AmzMwsApi\AmazonOrderList;
use Thecodebunny\AmzMwsApi\AmazonProductList;
use Thecodebunny\AmzMwsApi\AmazonProductInfo;

class MwsController extends Controller
{
    public function fetchAllProducts(Request $request, $country)
    {
        $settings = MwsApiSetting::where($request->input('company_id'))->first();
        $config = [
            'merchantId' => $settings->merchant_id,
            'marketplaceId' => 'A1F83G8C2ARO7P',
            'keyId' => $settings->key_id,
            'secretKey' => $settings->secret_key,
            'amazonServiceUrl' => 'https://mws-eu.amazonservices.com/',
        ];
        $amz = new AmazonProductList($config);
        $allProducts = Item::all()->toArray();
        foreach ($allProducts as $product) {
            $amzItem = AmzItem::where('inv_item_id', $product['id'])->first();
            $amz->setProductIds($amzItem->ean);
            $amz->setIdType('EAN');
            $amzAsin = $amz->fetchProductList();
            $asin = $amzAsin['GetMatchingProductForIdResult'];
            $this->addUpdateAsin($product['item_id'], $product['id'], $product['sku'], $amzItem->ean, $country, $asin);
        }
    }

    public function fetchAmazonItem(Request $request, $item_id, $inv_item_id, $sku, $ean, $country)
    {
        $settings = MwsApiSetting::where($request->input('company_id'))->first();
        $config = [
            'merchantId' => $settings->merchant_id,
            'marketplaceId' => 'A1F83G8C2ARO7P',
            'keyId' => $settings->key_id,
            'secretKey' => $settings->secret_key,
            'amazonServiceUrl' => 'https://mws-eu.amazonservices.com/',
        ];
        $amz = new AmazonProductList($config);
        $amz->setProductIds($ean);
        $amz->setIdType('EAN');
        $amzAsin = $amz->fetchProductList();
        $asin = $amzAsin['GetMatchingProductForIdResult'];
        var_dump($asin);
        $this->addUpdateAsin($item_id, $inv_item_id, $sku, $ean, $country, $asin);
        $this->updateAmazonItem($item_id, $inv_item_id, $ean, $asin, $country);
    }

    public function addUpdateAsin($item_id, $inv_item_id, $sku, $ean, $country, $asin)
    {
        $asinModel = 'Modules\TcbAmazonSync\Models\Amazon\\'. $country .'Item';
            
        $dbAsin = $asinModel::where('ean', $ean)->first();
        if (!$dbAsin || empty($dbAsin)) {
            $dbAsin = new $asinModel;
        } 
            
        $dbAsin->enable = 'on';
        $dbAsin->item_id = $inv_item_id;
        $dbAsin->sku = $sku;
        $dbAsin->ean = $ean;
        $dbAsin->brand = $asin['Products']['Product']['AttributeSets']['ItemAttributes']['Brand'];
        if (array_key_exists('Color', $asin['Products']['Product']['AttributeSets']['ItemAttributes'])) {
            $dbAsin->color = $asin['Products']['Product']['AttributeSets']['ItemAttributes']['Color'];
        }
        if (array_key_exists('Size', $asin['Products']['Product']['AttributeSets']['ItemAttributes'])) {
            $dbAsin->size = $asin['Products']['Product']['AttributeSets']['ItemAttributes']['Size'];
        }
        if (array_key_exists('MaterialType', $asin['Products']['Product']['AttributeSets']['ItemAttributes'])) {
            $dbAsin->material = $asin['Products']['Product']['AttributeSets']['ItemAttributes']['MaterialType'];
        }
        $dbAsin->title = str_replace('Zoomyo ','',str_replace('zoomyo ', '', $asin['Products']['Product']['AttributeSets']['ItemAttributes']['Title']));
        $dbAsin->ean = $asin['@attributes']['Id'];
        $dbAsin->asin = $asin['Products']['Product']['Identifiers']['MarketplaceASIN']['ASIN'];
        $dbAsin->save();
    }

    public function updateAmazonItem($item_id, $inv_item_id, $ean, $asin, $country)
    {
        $amazonItem = AmzItem::where('ean', $ean)->first();
        if (! $amazonItem || empty($amazonItem)) {
            $amazonItem = new AmzItem;
        }
        $amazonItem->ean = $ean;
        $amazonItem->item_id = $item_id;
        $amazonItem->inv_item_id = $inv_item_id;
        if ($country == 'Uk') {
            $amazonItem->uk_asin = $asin['Products']['Product']['Identifiers']['MarketplaceASIN']['ASIN'];
        }
        $amazonItem->save();
        $data = [
            'item_id' => $item_id,
            'inv_item_id' => $inv_item_id,
            'ean'   => $ean,
            'asin' => $asin,
        ];
        var_dump($data);
    }

}