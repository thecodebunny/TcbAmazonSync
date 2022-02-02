<?php

namespace Modules\TcbAmazonSync\Http\Controllers\Amazon;

use DebugBar\DebugBar;
use App\Abstracts\Http\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

//Module TCB Amazon Sync
use Modules\TcbAmazonSync\Models\Amazon\Item;
use Modules\TcbAmazonSync\Models\Amazon\Feed;
use Modules\TcbAmazonSync\Models\Amazon\Issue;
use Modules\TcbAmazonSync\Models\Amazon\Aplus;
use Modules\TcbAmazonSync\Models\Amazon\Categories;
use Modules\TcbAmazonSync\Models\Amazon\SpApiSetting;
use Modules\TcbAmazonSync\Models\Amazon\MwsApiSetting;
use Modules\TcbAmazonSync\Http\Controllers\Amazon\Xml;


//Amazon SP API
use Thecodebunny\SpApi\Endpoint;
use Thecodebunny\SpApi\FeedType;
use Thecodebunny\SpApi\Document;
use Thecodebunny\SpApi\Api\FeedsApi;
use Thecodebunny\SpApi\Configuration;
use Thecodebunny\SpApi\Api\OrdersApi;
use Thecodebunny\SpApi\Api\CatalogApi;
use Thecodebunny\SpApi\Api\ListingsApi;
use Thecodebunny\SpApi\Api\AplusContentApi;
use Thecodebunny\SpApi\Api\ProductTypeDefinitionsApi;
use Thecodebunny\SpApi\Model\Feeds;
use Thecodebunny\SpApi\Model\Feeds\CreateFeedSpecification;
use Thecodebunny\SpApi\Model\Listings\ListingsItemPatchRequest;
use Thecodebunny\SpApi\Model\Listings\PatchOperation;

class SpApi extends Controller
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

    public function getAllItems(Request $request)
    {
        
        if ($this->country == 'Uk') {
            $mpIds = 'A1F83G8C2ARO7P';
        }
        $items = Item::where('company_id', $this->companyId)->where('country', $this->country)->all();
        $issue_locale = 'en_US';
        $seller_id = $this->settings->seller_id;
        $marketplace_ids = $mpIds;
        $included_data = ['summaries','attributes','issues','offers'];
        if (count($items)) {
            foreach ($items as $item) {
                $apiInstance = new ListingsApi($this->config);
                //dump($apiInstance);
                $result = $apiInstance->getListingsItem($seller_id, $item->sku, $mpIds, $issue_locale, $included_data);
                $this->updateAmazonItem($result, $item);
            }
        }
    }

    public function getItem($id)
    {
        
        if ($this->country == 'Uk') {
            $mpIds = 'A1F83G8C2ARO7P';
        }
        $issue_locale = 'en_US';
        $dbItem = Item::where('id', $id)->first();
        $apiInstance = new ListingsApi($this->config);
        $included_data = ['summaries','attributes','issues','offers','fulfillmentAvailability'];
        $result = $apiInstance->getListingsItem($this->settings->seller_id, $dbItem->sku, $mpIds, $issue_locale, $included_data);
        $this->updateAmazonItem($result, $dbItem);
    }

    public function updateAmazonItem($item, $dbItem)
    {
        $summary = $item->getSummaries();
        $fulfill = $item->getFulfillmentAvailability();
        $attributes = $item->getAttributes();
        $issues = $item->getIssues();
        $offers = $item->getOffers();
        $dbItem->product_type = $summary[0]->getProductType();
        if ($attributes && !empty($attributes)) {
            if (array_key_exists('brand', $attributes)) {
                $dbItem->brand = $attributes['brand'][0]->value;
            }
            if (array_key_exists('generic_keyword', $attributes)) {
                $dbItem->keywords = $attributes['generic_keyword'][0]->value;
            }
            if (array_key_exists('fulfillment_availability', $attributes)) {
                $dbItem->quantity = $fulfill[0]->getQuantity();
                if(array_key_exists('lead_time_to_ship_max_days', $attributes['fulfillment_availability'][0])) {
                    $dbItem->lead_time_to_ship_max_days = $attributes['fulfillment_availability'][0]->lead_time_to_ship_max_days;
                }
            }
            if (array_key_exists('recommended_browse_nodes', $attributes)) {
                $dbItem->category_id = $attributes['recommended_browse_nodes'][0]->value;
            }
            if (array_key_exists('bullet_point', $attributes)) {
                if (isset($attributes['bullet_point'][0])) {
                    $dbItem->bullet_point_1 = $attributes['bullet_point'][0]->value;
                } else {
                    $dbItem->bullet_point_1 = NULL;
                }
                if (isset($attributes['bullet_point'][1])) {
                    $dbItem->bullet_point_2 = $attributes['bullet_point'][1]->value;
                } else {
                    $dbItem->bullet_point_2 = NULL;
                }
                if (isset($attributes['bullet_point'][2])) {
                    $dbItem->bullet_point_3 = $attributes['bullet_point'][2]->value;
                } else {
                    $dbItem->bullet_point_3 = NULL;
                }
                if (isset($attributes['bullet_point'][3])) {
                    $dbItem->bullet_point_4 = $attributes['bullet_point'][3]->value;
                } else {
                    $dbItem->bullet_point_4 = NULL;
                }
                if (isset($attributes['bullet_point'][4])) {
                    $dbItem->bullet_point_5 = $attributes['bullet_point'][4]->value;
                } else {
                    $dbItem->bullet_point_5 = NULL;
                }
                if (isset($attributes['bullet_point'][5])) {
                    $dbItem->bullet_point_6 = $attributes['bullet_point'][5]->value;
                } else {
                    $dbItem->bullet_point_6 = NULL;
                }
            }
            if (array_key_exists('item_name', $attributes)) {
                $dbItem->title = $attributes['item_name'][0]->value;
            }
            if (array_key_exists('color', $attributes)) {
                $dbItem->color = $attributes['color'][0]->value;
            }
            if (array_key_exists('product_description', $attributes)) {
                $dbItem->description = $attributes['product_description'][0]->value;
            }
            if (array_key_exists('country_of_origin', $attributes)) {
                $dbItem->country_of_origin = $attributes['country_of_origin'][0]->value;
            }
            if (array_key_exists('main_product_image_locator', $attributes)) {
                $mainPic = file_get_contents($attributes['main_product_image_locator'][0]->media_location);
                $mainName = basename($attributes['main_product_image_locator'][0]->media_location);
                $picFolder = 'items/'. $this->country .'/'. $dbItem->asin . '/mainImage/' . $mainName;
                Storage::disk('public')->deleteDirectory('items/'. $this->country .'/'. $dbItem->asin . '/mainImage/');
                Storage::disk('public')->put($picFolder, $mainPic, 'public');
                $dbItem->main_picture = $picFolder;
            }
            Storage::disk('public')->deleteDirectory('items/'. $this->country .'/'. $dbItem->asin . '/variants/');
            if (array_key_exists('other_product_image_locator_1', $attributes)) {
                $pic1 = file_get_contents($attributes['other_product_image_locator_1'][0]->media_location);
                $pic1Name = basename($attributes['other_product_image_locator_1'][0]->media_location);
                $pic1Folder = 'items/'. $this->country .'/'. $dbItem->asin . '/variants/1-' . $pic1Name;
                Storage::disk('public')->put($pic1Folder, $pic1, 'public');
                $dbItem->picture_1 = $pic1Folder;
            }
            if (array_key_exists('other_product_image_locator_2', $attributes)) {
                $pic2 = file_get_contents($attributes['other_product_image_locator_2'][0]->media_location);
                $pic2Name = basename($attributes['other_product_image_locator_2'][0]->media_location);
                $pic2Folder = 'items/'. $this->country .'/'. $dbItem->asin . '/variants/2-' . $pic2Name;
                Storage::disk('public')->put($pic2Folder, $pic2, 'public');
                $dbItem->picture_2 = $pic2Folder;
            }
            if (array_key_exists('other_product_image_locator_3', $attributes)) {
                $pic3 = file_get_contents($attributes['other_product_image_locator_3'][0]->media_location);
                $pic3Name = basename($attributes['other_product_image_locator_3'][0]->media_location);
                $pic3Folder = 'items/'. $this->country .'/'. $dbItem->asin . '/variants/3-' . $pic3Name;
                Storage::disk('public')->put($pic3Folder, $pic3, 'public');
                $dbItem->picture_3 = $pic3Folder;
            }
            if (array_key_exists('other_product_image_locator_4', $attributes)) {
                $pic4 = file_get_contents($attributes['other_product_image_locator_4'][0]->media_location);
                $pic4Name = basename($attributes['other_product_image_locator_4'][0]->media_location);
                $pic4Folder = 'items/'. $this->country .'/'. $dbItem->asin . '/variants/4-' . $pic4Name;
                Storage::disk('public')->put($pic4Folder, $pic4, 'public');
                $dbItem->picture_4 = $pic4Folder;
            }
            if (array_key_exists('other_product_image_locator_5', $attributes)) {
                $pic5 = file_get_contents($attributes['other_product_image_locator_5'][0]->media_location);
                $pic5Name = basename($attributes['other_product_image_locator_5'][0]->media_location);
                $pic5Folder = 'items/'. $this->country .'/'. $dbItem->asin . '/variants/5-' . $pic5Name;
                Storage::disk('public')->put($pic5Folder, $pic5, 'public');
                $dbItem->picture_5 = $pic5Folder;
            }
            if (array_key_exists('other_product_image_locator_6', $attributes)) {
                $pic6 = file_get_contents($attributes['other_product_image_locator_6'][0]->media_location);
                $pic6Name = basename($attributes['other_product_image_locator_6'][0]->media_location);
                $pic6Folder = 'items/'. $this->country .'/'. $dbItem->asin . '/variants/6-' . $pic6Name;
                Storage::disk('public')->put($pic6Folder, $pic6, 'public');
                $dbItem->picture_6 = $pic6Folder;
            }
            if (array_key_exists('other_product_image_locator_7', $attributes)) {
                $pic7 = file_get_contents($attributes['other_product_image_locator_7'][0]->media_location);
                $pic7Name = basename($attributes['other_product_image_locator_7'][0]->media_location);
                $pic7Folder = 'items/'. $this->country .'/'. $dbItem->asin . '/variants/7-' . $pic7Name;
                Storage::disk('public')->put($pic7Folder, $pic7, 'public');
                $dbItem->picture_7 = $pic7Folder;
            }
            if (array_key_exists('purchasable_offer', $attributes)) {
                $dbItem->price = $attributes['purchasable_offer'][0]->our_price[0]->schedule[0]->value_with_tax;
                if (isset($attributes['purchasable_offer'][0]->discounted_price)) {
                    if ($attributes['purchasable_offer'][0]->discounted_price && $attributes['purchasable_offer'][0]->discounted_price[0]->schedule[0]->value_with_tax < $attributes['purchasable_offer'][0]->our_price[0]->schedule[0]->value_with_tax) {
                        $dbItem->price = $attributes['purchasable_offer'][0]->discounted_price[0]->schedule[0]->value_with_tax;
                    }
                }

            }
        }

        $dbItem->save();
        Issue::where('amz_item_id', $dbItem->id)->delete();
        if( $issues && !empty($issues) ) {
            foreach ($issues as $issue) {
                $dbIssue = new Issue;
                $dbIssue->item_id = $dbItem->item_id;
                $dbIssue->amz_item_id = $dbItem->id;
                $dbIssue->code = $issue->getCode();
                $dbIssue->message = $issue->getMessage();
                $dbIssue->severity = $issue->getSeverity();
                $dbIssue->attribute_names = implode(',', $issue->getAttributeNames());
                $dbIssue->save();
            }
        }
        dump( $item );
    }

    public function updateAmazonItemStock($country, $id, $qty)
    {
        dump($this->settings);
        $seller_id = $this->settings->seller_id;
        $item = Item::where('id', $id)->where('country', $country)->first();
        $productType = 'PRODUCT';
        if ($country == 'Uk')
        {
            $mpIds = 'A1F83G8C2ARO7P';
        }

        $apiInstance = new ListingsApi($this->config);
        $marketplace_ids = $mpIds;
        $body = new ListingsItemPatchRequest();
        $issue_locale = 'en_US';
        $body->setProductType($productType);
        $patches = [
            [
                'op'    => 'replace',
                'path'  => 'fulfillment_availability',
                'value' => [[
                    'fulfillment_channel_code' => 'DEFAULT',
                    'quantity'  =>  (int)$qty
                ]]
            ]];
        $body->setPatches(($patches));
        try {
            $result = $apiInstance->patchListingsItem($seller_id, $item->sku, $mpIds, $body, $issue_locale);
            dump($result);
        } catch (Exception $e) {
            echo 'Exception when calling ListingsApi->patchListingsItem: ', $e->getMessage(), PHP_EOL;
        }
    }

    public function updateAmazonItemTitle($country, $id, $title)
    {
        $seller_id = $this->settings->seller_id;
        $item = Item::where('id', $id)->where('country', $country)->first();
        $productType = 'PRODUCT';
        if ($country == 'Uk')
        {
            $mpIds = 'A1F83G8C2ARO7P';
        }

        $apiInstance = new ListingsApi($this->config);
        $marketplace_ids = $mpIds;
        $body = new ListingsItemPatchRequest();
        $issue_locale = 'en_US';
        $body->setProductType($productType);
        $patches = [
            [
                'op'    => 'replace',
                'path'  => 'item_name',
                'value' => [[
                    'value' => ''. $title .''
                ]]
            ]];
        $body->setPatches(($patches));
        try {
            $result = $apiInstance->patchListingsItem($seller_id, $item->sku, $mpIds, $body, $issue_locale);
            dump($result);
        } catch (Exception $e) {
            echo 'Exception when calling ListingsApi->patchListingsItem: ', $e->getMessage(), PHP_EOL;
        }
    }

    public function updateAmazonItemPrice($country, $id, $price, $currency)
    {
        $seller_id = $this->settings->seller_id;
        $item = Item::where('id', $id)->where('country', $country)->first();
        $productType = 'PRODUCT';
        if ($country == 'Uk')
        {
            $mpIds = 'A1F83G8C2ARO7P';
        }

        $apiInstance = new ListingsApi($this->config);
        $marketplace_ids = $mpIds;
        $body = new ListingsItemPatchRequest();
        $issue_locale = 'en_US';
        $body->setProductType($productType);
        $patches = [
            [
                'op'    => 'replace',
                'path'  => 'purchasable_offer',
                'value' => [[
                    "marketplace_id" => ''. $mpIds .'',
                    'currency' => ''. $currency .'',
                    'our_price' => [[
                        'schedule' => [[
                            'value_with_tax' => $price
                        ]]
                    ]]
                ]]
            ]];
        $body->setPatches(($patches));
        try {
            $result = $apiInstance->patchListingsItem($seller_id, $item->sku, $mpIds, $body, $issue_locale);
            \Debugbar::addMessage($result);
            \Debugbar::addMessage($body);
            dump($result);
        } catch (Exception $e) {
            echo 'Exception when calling ListingsApi->patchListingsItem: ', $e->getMessage(), PHP_EOL;
        }
    }

    public function updateAmazonSalePrice($country, $id, $startDate, $endDate, $saleprice, $currency)
    {
        $seller_id = $this->settings->seller_id;
        $item = Item::where('id', $id)->where('country', $country)->first();
        $productType = 'PRODUCT';
        if ($country == 'Uk')
        {
            $mpIds = 'A1F83G8C2ARO7P';
        }

        $apiInstance = new ListingsApi($this->config);
        $marketplace_ids = $mpIds;
        $body = new ListingsItemPatchRequest();
        $issue_locale = 'en_US';
        $body->setProductType($productType);
        $patches = [
            [
                'op'    => 'replace',
                'path'  => 'purchasable_offer',
                'value' => [[
                    "marketplace_id" => ''. $mpIds .'',
                    'currency' => ''. $currency .'',
                    'discounted_price' => [[
                        'schedule' => [[
                            'end_at' => $endDate,
                            'start_at' => $startDate,
                            'value_with_tax' => $price
                        ]]
                    ]]
                ]]
            ]];
        $body->setPatches(($patches));
        try {
            $result = $apiInstance->patchListingsItem($seller_id, $item->sku, $mpIds, $body, $issue_locale);
            \Debugbar::addMessage($result);
            \Debugbar::addMessage($body);
            dump($result);
        } catch (Exception $e) {
            echo 'Exception when calling ListingsApi->patchListingsItem: ', $e->getMessage(), PHP_EOL;
        }
    }

    public function getOrders(Request $request)
    {
        
        $apiInstance = new OrdersApi($this->config);
        $marketplace_ids = ['A1F83G8C2ARO7P'];
        $created_after = date('Y-m-d', strtotime('-3 days'));
        //$created_before = '2021-11-30';
        $data_elements = [];
        try {
            $result = $apiInstance->getOrders(
                $marketplace_ids,
                $created_after
            );
            return $result['payload']['orders'];

        } catch (Exception $e) {
            echo 'Exception when calling OrdersApi->getOrders: ', $e->getMessage(), PHP_EOL;
        }
    }

    public function getOrderBuyer($id)
    {
        
        $apiInstance = new OrdersApi($this->config);
        $marketplace_ids = ['A1F83G8C2ARO7P'];
        try {
            return $apiInstance->getOrderBuyerInfo($id)->getPayload();
        } catch (Exception $e) {
            echo 'Exception when calling OrdersApi->getOrderAddress: ', $e->getMessage(), PHP_EOL;
        }

    }

    public function getOrderAddress($id)
    {
        
        $apiInstance = new OrdersApi($this->config);
        try {
            return $apiInstance->getOrderAddress($id)->getPayload();
        } catch (Exception $e) {
            echo 'Exception when calling OrdersApi->getOrderAddress: ', $e->getMessage(), PHP_EOL;
        }

    }

    public function getOrderItems($id)
    {
        
        $apiInstance = new OrdersApi($this->config);
        try {
            $items = $apiInstance->getOrderItems($id);
            return $items->getPayload();
        } catch (Exception $e) {
            echo 'Exception when calling OrdersApi->getOrderAddress: ', $e->getMessage(), PHP_EOL;
        }

    }

    public function getAplusContents()
    {
        $items = Item::all();
        foreach ($items as $item) {
            $apiInstance = new AplusContentApi($this->config);
            if ($this->country == 'Uk') {
                $mpId = 'A1F83G8C2ARO7P';
            }
            $asin = $item->asin;
            $marketplace_id = $mpId;
            try {
                $result = $apiInstance->searchContentPublishRecords($marketplace_id, $asin);
                $content = $result->getPublishRecordList();
                $this->addUpdateAplusContent($content[0], $item);
            } catch (Exception $e) {
                echo 'Exception when calling AplusContentApi->searchContentPublishRecords: ', $e->getMessage(), PHP_EOL;
            }
        }
    }

    public function addUpdateAplusContent($result, $item)
    {
        $dbContent = Aplus::where('item_id', $item->item_id)->where('amz_item_id', $item->id)->first();
        if (!$dbContent || empty($dbContent)) {
            $dbContent = new Aplus;
        }
        $dbContent->item_id = $item->item_id;
        $dbContent->amz_item_id = $item->id;
        $dbContent->content_reference_key = $result->getContentReferenceKey();
        $dbContent->asin = $result->getAsin();
        $dbContent->content_type = $result->getContentType();
        $dbContent->content_sub_type = $result->getContentSubType();
        $dbContent->save();
        $this->getContentDocument($dbContent);
    }

    public function getContentDocument($content)
    {
        $apiInstance = new AplusContentApi($this->config);
        if ($this->country == 'Uk') {
            $mpId = 'A1F83G8C2ARO7P';
        }
        $marketplace_id = $mpId;
        $dataSets = ['CONTENTS','METADATA'];
        try {
            $result = $apiInstance->getContentDocument($content->content_reference_key, $mpId, $dataSets);
            dump($result);
        } catch (Exception $e) {
            echo 'Exception when calling AplusContentApi->getContentDocument: ', $e->getMessage(), PHP_EOL;
        }
    }
    
}