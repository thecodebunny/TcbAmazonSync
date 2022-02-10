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
use Modules\TcbAmazonSync\Models\Amazon\Issue;
use Modules\TcbAmazonSync\Models\Amazon\Aplus;
use Modules\TcbAmazonSync\Models\Amazon\Categories;
use Modules\TcbAmazonSync\Models\Amazon\ProductType;
use Modules\TcbAmazonSync\Models\Amazon\SpApiSetting;
use Modules\TcbAmazonSync\Models\Amazon\MwsApiSetting;
use Modules\TcbAmazonSync\Http\Controllers\Amazon\Xml;
use Modules\TcbAmazonSync\Http\Controllers\Amazon\Feeds\Image;


//Amazon SP API
use Thecodebunny\SpApi\Endpoint;
use Thecodebunny\SpApi\Document;
use Thecodebunny\SpApi\Configuration;
use Thecodebunny\SpApi\Api\OrdersApi;
use Thecodebunny\SpApi\Api\CatalogApi;
use Thecodebunny\SpApi\Api\ListingsApi;
use Thecodebunny\SpApi\Api\AplusContentApi;
use Thecodebunny\SpApi\Api\ListingsRestrictionsApi;
use Thecodebunny\SpApi\Api\ProductTypeDefinitionsApi;
use Thecodebunny\SpApi\Model\Listings\PatchOperation;
use Thecodebunny\SpApi\Model\Listings\ListingsItemPutRequest;
use Thecodebunny\SpApi\Model\Listings\ListingsItemPatchRequest;

class SpApi extends Controller
{

    private $country;
    private $config;
    private $settings;
    private $companyId;
    private $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
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

    public function getProductTypes($country, $keywords)
    {
        $apiInstance = new ProductTypeDefinitionsApi($this->config);
        $mpIds = 'A1F83G8C2ARO7P, A1PA6795UKMFR9, ATVPDKIKX0DER, A1RKKUPIHCS9HS, A13V1IB3VIYZZH, APJ6JRA9NG5V4, A1805IZSGTT6HS, A1C3SOZRARQ6R3, A2NODRKZP88ZB9';

        $keywords = '';

        try {
            $result = $apiInstance->searchDefinitionsProductTypes($mpIds, $keywords);
            dump($result);
            if ($result->getProductTypes()) {
                $pTypes = $result['product_types'];
                if ($pTypes && !empty($pTypes)) {
                    foreach ($pTypes as $type) {
                        dump($type);
                        $dbType = ProductType::where('name', $type->getName())->first();
                        if ($dbType || empty($dbType)) {
                            $dbType = new ProductType;
                        }
                        $dbType->name = $type->getName();
                        if (in_array('A1F83G8C2ARO7P', $type->getMarketplaceIds())) {
                            $dbType->is_uk = true;
                        }
                        if (in_array('A1PA6795UKMFR9', $type->getMarketplaceIds())) {
                            $dbType->is_de = true;
                        }
                        if (in_array('ATVPDKIKX0DER', $type->getMarketplaceIds())) {
                            $dbType->is_us = true;
                        }
                        if (in_array('A1RKKUPIHCS9HS', $type->getMarketplaceIds())) {
                            $dbType->is_es = true;
                        }
                        if (in_array('A13V1IB3VIYZZH', $type->getMarketplaceIds())) {
                            $dbType->is_fr = true;
                        }
                        if (in_array('APJ6JRA9NG5V4', $type->getMarketplaceIds())) {
                            $dbType->is_it = true;
                        }
                        if (in_array('A1805IZSGTT6HS', $type->getMarketplaceIds())) {
                            $dbType->is_nl = true;
                        }
                        if (in_array('A1C3SOZRARQ6R3', $type->getMarketplaceIds())) {
                            $dbType->is_pl = true;
                        }
                        if (in_array('A2NODRKZP88ZB9', $type->getMarketplaceIds())) {
                            $dbType->is_se = true;
                        }
                        $dbType->save();
                    }
                } else {
                    echo $keywords;
                    echo 'No Product Types Found, Please Search another Query.';
                }
            }
        } catch (Exception $e) {
            echo 'Exception when calling ProductTypeDefinitionsApi->searchDefinitionsProductTypes: ', $e->getMessage(), PHP_EOL;
        }
    }

    public function uploadUpdateAllItems()
    {
        $items = AmzItem::all();
        foreach($items as $item) {
            $this->uploadItem($item->id);
        }
    }
    public function uploadItem($id)
    {
        $item = Item::where('id', $id)->first();
        
        $apiInstance = new ListingsApi($this->config);
        if ($item->country == 'Uk') {
            $mpId = 'A1F83G8C2ARO7P';
            $item->is_uploaded_uk = true;
            $item->save();
        }
        if($item->asin) {
            $sugAsin = "";
        }
        $body = new ListingsItemPutRequest();
        $body->setProductType('PRODUCT');
        $body->setRequirements('LISTING_OFFER_ONLY');
        $issue_locale = 'en_US';

        if ($item->title) {
            $itemTitle = [[
                'value'=>  ''. $item->title .'',
                'marketplace_id'=> ''. $mpId .''
            ]];
        } else {
            $itemTitle = [];
        }

        if ($item->country_of_origin) {
            $countryOfOrigin = [[
                'value'=>  ''. $item->country_of_origin .'',
                'marketplace_id'=> ''. $mpId .''
            ]];
        } else {
            $countryOfOrigin = [[
                'value'=>  'DE',
                'marketplace_id'=> ''. $mpId .''
            ]];
        }

        if ($item->asin) {
            $itemAsin = [[
                'value'=> ''. $item->asin .'',
                'marketplace_id'=> ''. $mpId .''
            ]];
        } else {
            $itemAsin = [];
        }

        if ($item->ean) {
            $itemEan = [[
                'value'=>  ''. $item->ean .'',
                'type'=>  'ean',
                'marketplace_id'=> ''. $mpId .''
            ]];
        } else {
            $itemEan = [];
        }

        if ($item->price) {
            $itemPrice = [[
                'marketplace_id' => ''. $mpId .'',
                'currency' => ''. $item->currency_code .'',
                'start_at' => [
                    'value' => date("Y-m-d H:i:s")
                ],
                'our_price' => [
                    [
                        'schedule' => [
                            [
                                'value_with_tax' => $item->price
                            ]
                        ]
                    ]
                ],
                'list_price' => [
                    [
                        'schedule' => [
                            [
                                'value_with_tax' => $item->price
                            ]
                        ]
                    ]
                ],
                'uvp_list_price' => [
                    [
                        'schedule' => [
                            [
                                'value_with_tax' => $item->price
                            ]
                        ]
                    ]
                ]
            ]];
            //$this->uploadUpdateOffer($item);
        } else {
            $itemPrice = [];
        }

        if ($item->quantity) {
            $itemQuantity = [[
                'fulfillment_channel_code'=>  'DEFAULT',
                'quantity'=>  $item->quantity,
                'marketplace_id'=> ''. $mpId .''
            ]];
        } else {
            $itemQuantity = [[
                'fulfillment_channel_code'=>  'DEFAULT',
                'quantity'=> 0,
                'marketplace_id'=> ''. $mpId .''
            ]];
        }
        
        if ($item->category_id) {
            $itemCategory = [[
                'value'=>  ''. $item->category_id .'',
                'marketplace_id'=> ''. $mpId .''
            ]];
        } else {
            $itemCategory = [];
        }
        
        if ($item->keywords) {
            $itemKeywords = [[
                'value'=>  ''. $item->keywords .'',
                'marketplace_id'=> ''. $mpId .''
            ]];
        } else {
            $itemKeywords = [];
        }

        $itemBulletPoints = [
            [
                'value'=>  ''. $item->bullet_point_1 .'',
                'marketplace_id'=> ''. $mpId .''
            ], 
            [
                'value'=>  ''. $item->bullet_point_2 .'',
                'marketplace_id'=> ''. $mpId .''
            ], 
            [
                'value'=>  ''. $item->bullet_point_3 .'',
                'marketplace_id'=> ''. $mpId .''
            ], 
            [
                'value'=>  ''. $item->bullet_point_4 .'',
                'marketplace_id'=> ''. $mpId .''
            ], 
            [
                'value'=>  ''. $item->bullet_point_5 .'',
                'marketplace_id'=> ''. $mpId .''
            ]
        ];

        if ($item->color) {
            $itemColor = [[
                'value'=>  ''. $item->color .'',
                'marketplace_id'=> ''. $mpId .''
            ]];
        } else {
            $itemColor = [];
        }

        if ($item->brand) {
            $itemBrand = [[
                'value'=>  ''. $item->brand .'',
                'marketplace_id'=> ''. $mpId .''
            ]];
        } else {
            $itemBrand = [];
        }

        if ($item->description) {
            $itemDescription = [[
                'value'=>  ''. $item->description .'',
                'marketplace_id'=> ''. $mpId .''
            ]];
        } else {
            $itemDescription = [];
        }

        $attributes = [
            'condition_type'=> [
              [
                'value'=> 'new_new',
                'marketplace_id'=> ''. $mpId .''
              ]
            ],
            'item_name'=> $itemTitle,
            'country_of_origin'=> $countryOfOrigin,
            'merchant_suggested_asin'=> $itemAsin,
            'externally_assigned_product_identifier'=> $itemEan,
            'recommended_browse_nodes'=> $itemCategory,
            'purchasable_offer'=> $itemPrice,
            'fulfillment_availability'=> $itemQuantity,
            'generic_keyword'=> $itemKeywords,
            'bullet_point'=> $itemBulletPoints,
            'color'=> $itemColor,
            'brand'=> $itemBrand,
            'product_description'=> $itemDescription,
        ];
        $body->setAttributes($attributes);
        dump($attributes);
        try {
            $result = $apiInstance->putListingsItem($this->settings->seller_id, $item->sku, $mpId, $body, $issue_locale);
            dump($result);
            if($result->getStatus() == 'ACCEPTED') {
                if ($this->country == 'Uk') {
                    $item->is_uploaded_uk = true;
                    $item->save();
                }
            }
            if($result->getStatus() == 'ACCEPTED') {
                $itemResponse['statusmessage'] = 'SUCCESS';
                $itemResponse['heading'] = '<h2 class="text-white">SUCCESS</h2>';
                $itemResponse['message'] = 'Item Successfully Updated.';
                if($result->getIssues()) {
                    $itemResponse['message'] .= 'Below were the issues raised by API Response.<br>';
                    foreach($result->getIssues() as $issue) {
                        $itemResponse['message'] .= $issue->getMessage() . '<br>';
                        if($issue->getAttributeNames()) {
                            foreach($issue->getAttributeNames() as $name)
                            $itemResponse['message'] .= $name . '<br>';
                        }
                    }
                }
                sleep(60);
                if ($item->quantity) {
                    $this->updateAmazonItemStock($item->id, $item->quantity);
                }
                if ($item->price) {
                    $this->updateAmazonItemPrice($item->id, $item->price, $item->currency_code);
                }
                if ($item->sale_price) {
                    $this->updateAmazonSalePrice($item->id, $item->sale_start_date, $item->sale_end_date, $item->sale_price, $item->currency_code);
                }
                if ($item->main_picture || $item->picture_2 || $item->picture_3 || $item->picture_4 || $item->picture_5 || $item->picture_6 || $item->picture_7) {
                    $imageController = new Image($this->request);
                    $imageController->createImageFeedDocument($item->id);
                }
            } else {
                $itemResponse['statusmessage'] = '<h2 class="text-white">ERROR</h2>';
                $itemResponse['heading'] = '<h2>ERROR!</h2>';
                $itemResponse['message'] = 'There has been an error while updating Item.<br>';
                if($result->getIssues()) {
                    foreach($result->getIssues() as $issue) {
                        $itemResponse['message'] .= $issue->getMessage() . '<br>';
                        if($issue->getAttributeNames()) {
                            foreach($issue->getAttributeNames() as $name)
                            $itemResponse['message'] .= $name . '<br>';
                        }
                    }
                }
            }
            dump($itemResponse);
            return $itemResponse;
        } catch (Exception $e) {
            echo 'Exception when calling ListingsApi->putListingsItem: ', $e->getMessage(), PHP_EOL;
        }
    }

    public function getAllItems(Request $request)
    {
        
        if ($this->country == 'Uk') {
            $mpIds = 'A1F83G8C2ARO7P';
            $items = Item::where('company_id', $this->companyId)->where('country', $this->country)->where('is_uploaded_uk', true)->all();
        }
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

    public function getAmzItem($id)
    {
        $issue_locale = 'en_US';
        $dbItem = Item::where('id', $id)->first();
        
        if ($dbItem->country == 'Uk') {
            $mpIds = 'A1F83G8C2ARO7P';
        }
        $apiInstance = new ListingsApi($this->config);
        $included_data = ['summaries','attributes','issues','offers','fulfillmentAvailability'];
        $result = $apiInstance->getListingsItem($this->settings->seller_id, $dbItem->sku, $mpIds, $issue_locale, $included_data);
        $this->updateAmazonItem($result, $dbItem);
    }

    public function getItem($id)
    {
        $issue_locale = 'en_US';
        $dbItem = Item::where('id', $id)->first();
        
        if ($dbItem->country == 'Uk') {
            $mpIds = 'A1F83G8C2ARO7P';
        }
        $apiInstance = new ListingsApi($this->config);
        $included_data = ['summaries','attributes','issues','offers','fulfillmentAvailability'];
        try {
            $result = $apiInstance->getListingsItem($this->settings->seller_id, $dbItem->sku, $mpIds, $issue_locale, $included_data);
            $this->updateAmazonItem($result, $dbItem);
        } catch (Exception $e) {
            echo 'Exception when calling FeedsApi->createFeed: ', $e->getMessage(), PHP_EOL;
        }
    }

    public function updateAmazonItem($item, $dbItem)
    {
        dump($item);
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
            if (array_key_exists('externally_assigned_product_identifier', $attributes)) {
                if ($attributes['externally_assigned_product_identifier'][0]->type == 'ean') {
                    $dbItem->ean = $attributes['externally_assigned_product_identifier'][0]->value;
                }
            }
            if (array_key_exists('generic_keyword', $attributes)) {
                $dbItem->keywords = $attributes['generic_keyword'][0]->value;
            }
            if ($fulfill && !empty($fulfill)) {
                $dbItem->quantity = $fulfill[0]->getQuantity();
            } else {
                if (array_key_exists('fulfillment_availability', $attributes)) {
                    if(isset($attributes['fulfillment_availability'][0]->quantity)) {
                        $dbItem->quantity = $attributes['fulfillment_availability'][0]->quantity;
                    }
                    if(array_key_exists('lead_time_to_ship_max_days', $attributes['fulfillment_availability'][0])) {
                        $dbItem->lead_time_to_ship_max_days = $attributes['fulfillment_availability'][0]->lead_time_to_ship_max_days;
                    }
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
                if (isset($attributes['purchasable_offer'][0]->our_price)) {
                    $dbItem->currency_code = $attributes['purchasable_offer'][0]->currency;
                }
                if (isset($attributes['purchasable_offer'][0]->our_price)) {
                    $dbItem->price = $attributes['purchasable_offer'][0]->our_price[0]->schedule[0]->value_with_tax;
                    if (isset($attributes['purchasable_offer'][0]->discounted_price)) {
                        if ($attributes['purchasable_offer'][0]->discounted_price && $attributes['purchasable_offer'][0]->discounted_price[0]->schedule[0]->value_with_tax < $attributes['purchasable_offer'][0]->our_price[0]->schedule[0]->value_with_tax) {
                            $dbItem->price = $attributes['purchasable_offer'][0]->discounted_price[0]->schedule[0]->value_with_tax;
                        }
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
                if($issue->getAttributeNames() > 1) {
                    $dbIssue->attribute_names = implode(',', $issue->getAttributeNames());
                } else {
                    $dbIssue->attribute_names = $issue->getAttributeNames();
                }
                $dbIssue->save();
            }
        }
    }

    public function updateAmazonItemBulletPoints($id)
    {
        $seller_id = $this->settings->seller_id;
        $item = Item::where('id', $id)->first();
        $productType = 'PRODUCT';
        if ($item->country == 'Uk')
        {
            $mpId = 'A1F83G8C2ARO7P';
        }

        $apiInstance = new ListingsApi($this->config);
        $body = new ListingsItemPatchRequest();
        $issue_locale = 'en_US';
        $body->setProductType($productType);
        if($item->bullet_point_1) {
            $p1 = [
                'value'=>  ''. htmlentities($item->bullet_point_1) .'',
                'marketplace_id'=> ''. $mpId .''
            ];
        } else {
            $p1 = [
                'value'=>  '',
                'marketplace_id'=> ''. $mpId .''
            ];
        }
        if($item->bullet_point_2) {
            $p2 = [
                'value'=>  ''. htmlentities($item->bullet_point_2) .'',
                'marketplace_id'=> ''. $mpId .''
            ];
        } else {
            $p2 = [
                'value'=>  '',
                'marketplace_id'=> ''. $mpId .''
            ];
        }
        if($item->bullet_point_3) {
            $p3 = [
                'value'=>  ''. htmlentities($item->bullet_point_3) .'',
                'marketplace_id'=> ''. $mpId .''
            ];
        } else {
            $p3 = [
                'value'=>  '',
                'marketplace_id'=> ''. $mpId .''
            ];
        }
        if($item->bullet_point_4) {
            $p4 = [
                'value'=>  ''. htmlentities($item->bullet_point_4) .'',
                'marketplace_id'=> ''. $mpId .''
            ];
        } else {
            $p4 = [
                'value'=>  '',
                'marketplace_id'=> ''. $mpId .''
            ];
        }
        if($item->bullet_point_5) {
            $p5 = [
                'value'=>  ''. htmlentities($item->bullet_point_5) .'',
                'marketplace_id'=> ''. $mpId .''
            ];
        } else {
            $p5 = [
                'value'=>  '',
                'marketplace_id'=> ''. $mpId .''
            ];
        }
        if($item->bullet_point_6) {
            $p6 = [
                'value'=>  ''. htmlentities($item->bullet_point_6) .'',
                'marketplace_id'=> ''. $mpId .''
            ];
        } else {
            $p6 = [
                'value'=>  '',
                'marketplace_id'=> ''. $mpId .''
            ];
        }
        $itemBulletPoints = [
            $p1, $p2, $p3, $p4, $p5, $p6
        ];
        $patches = [
            [
                'op'    => 'replace',
                'path'  => 'bullet_point',
                'value' => $itemBulletPoints
            ]
        ];
        $body->setPatches(($patches));
        try {
            $result = $apiInstance->patchListingsItem($seller_id, $item->sku, $mpId, $body, $issue_locale);
            if($result['status'] == 'ACCEPTED') {
                $apiReponse['statusmessage'] = 'SUCCESS';
                $bpResponse['heading'] = '<h2 class="text-white">SUCCESS</h2>';
                $bpResponse['message'] = 'Bullet Points Successfully Updated.';
            } else {
                $bpResponse['statusmessage'] = '<h2 class="text-white">ERROR</h2>';
                $bpResponse['message'] = 'There has been an error while updating Bullet Points.<br>';
                if($result['issues']) {
                    foreach($result['issues'] as $issue) {
                        $bpResponse['message'] .= $issue['message'] . '<br>';
                        $bpResponse['message'] .= $issue['attribute_names'][0] . '<br>';
                    }
                }
            }
            return $bpResponse;

        } catch (Exception $e) {
            echo 'Exception when calling ListingsApi->patchListingsItem: ', $e->getMessage(), PHP_EOL;
        }
    }

    public function updateAmazonItemDescription($id)
    {
        $seller_id = $this->settings->seller_id;
        $item = Item::where('id', $id)->first();
        $productType = 'PRODUCT';
        if ($item->country == 'Uk')
        {
            $mpIds = 'A1F83G8C2ARO7P';
        }

        $apiInstance = new ListingsApi($this->config);
        $body = new ListingsItemPatchRequest();
        $issue_locale = 'en_US';
        $body->setProductType($productType);
        $patches = [
            [
                'op'    => 'replace',
                'path'  => 'product_description',
                'value' => [[
                    'value' => ''. htmlentities($item->description) .'',
                    "marketplace_id" => ''. $mpIds .'',
                ]]
            ]
        ];
        $body->setPatches(($patches));
        try {
            $result = $apiInstance->patchListingsItem($seller_id, $item->sku, $mpIds, $body, $issue_locale);
            if($result['status'] == 'ACCEPTED') {
                $apiReponse['statusmessage'] = 'SUCCESS';
                $apiReponse['heading'] = '<h2 class="text-white">SUCCESS</h2>';
                $apiReponse['message'] = 'Description Successfully Updated.';
            } else {
                $apiReponse['statusmessage'] = '<h2 class="text-white">ERROR</h2>';
                $apiReponse['message'] = 'There has been an error while updating Description.<br>';
                if($result['issues']) {
                    foreach($result['issues'] as $issue) {
                        $apiReponse['message'] .= $issue['message'] . '<br>';
                        $apiReponse['message'] .= $issue['attribute_names'][0] . '<br>';
                    }
                }
            }
            return $apiReponse;

        } catch (Exception $e) {
            echo 'Exception when calling ListingsApi->patchListingsItem: ', $e->getMessage(), PHP_EOL;
        }
    }

    public function updateAmazonItemKeywords($id)
    {
        $seller_id = $this->settings->seller_id;
        $item = Item::where('id', $id)->first();
        $productType = 'PRODUCT';
        if ($item->country == 'Uk')
        {
            $mpIds = 'A1F83G8C2ARO7P';
        }

        $apiInstance = new ListingsApi($this->config);
        $body = new ListingsItemPatchRequest();
        $issue_locale = 'en_US';
        $body->setProductType($productType);
        $patches = [
            [
                'op'    => 'replace',
                'path'  => 'generic_keyword',
                'value' => [[
                    'value' => ''. $item->keywords .'',
                    "marketplace_id" => ''. $mpIds .'',
                ]]
            ]
        ];
        $body->setPatches(($patches));
        try {
            $result = $apiInstance->patchListingsItem($seller_id, $item->sku, $mpIds, $body, $issue_locale);
            if($result['status'] == 'ACCEPTED') {
                $apiReponse['statusmessage'] = 'SUCCESS';
                $apiReponse['heading'] = '<h2 class="text-white">SUCCESS</h2>';
                $apiReponse['message'] = 'Keywords Successfully Updated.';
            } else {
                $apiReponse['statusmessage'] = '<h2 class="text-white">ERROR</h2>';
                $apiReponse['message'] = 'There has been an error while updating Keywords.<br>';
                if($result['issues']) {
                    foreach($result['issues'] as $issue) {
                        $apiReponse['message'] .= $issue['message'] . '<br>';
                        $apiReponse['message'] .= $issue['attribute_names'][0] . '<br>';
                    }
                }
            }
            return $apiReponse;

        } catch (Exception $e) {
            echo 'Exception when calling ListingsApi->patchListingsItem: ', $e->getMessage(), PHP_EOL;
        }
    }

    public function updateAmazonItemCategory($id, $category)
    {
        $seller_id = $this->settings->seller_id;
        $item = Item::where('id', $id)->first();
        $productType = 'PRODUCT';
        if ($item->country == 'Uk')
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
                'path'  => 'recommended_browse_nodes',
                'value' => [[
                    'value' => ''. $category .'',
                    "marketplace_id" => ''. $mpIds .'',
                ]]
            ]
        ];
        $body->setPatches(($patches));
        try {
            $result = $apiInstance->patchListingsItem($seller_id, $item->sku, $mpIds, $body, $issue_locale);
            if($result['status'] == 'ACCEPTED') {
                $apiReponse['statusmessage'] = 'SUCCESS';
                $apiReponse['heading'] = '<h2 class="text-white">SUCCESS</h2>';
                $apiReponse['message'] = 'Category Successfully Updated.';
                $apiReponse['message'] .= dump($result);
            } else {
                $apiReponse['statusmessage'] = '<h2 class="text-white">ERROR</h2>';
                $apiReponse['message'] = 'There has been an error while updating category.<br>';
                if($result['issues']) {
                    foreach($result['issues'] as $issue) {
                        $apiReponse['message'] .= $issue['message'] . '<br>';
                        $apiReponse['message'] .= $issue['attribute_names'][0] . '<br>';
                    }
                }
            }
            return $apiReponse;

        } catch (Exception $e) {
            echo 'Exception when calling ListingsApi->patchListingsItem: ', $e->getMessage(), PHP_EOL;
        }
    }

    public function updateAmazonItemStock($id, $qty)
    {
        $seller_id = $this->settings->seller_id;
        $item = Item::where('id', $id)->first();
        $productType = 'PRODUCT';
        if ($item->country == 'Uk')
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
            ]
        ];
        $body->setPatches(($patches));
        try {
            $result = $apiInstance->patchListingsItem($seller_id, $item->sku, $mpIds, $body, $issue_locale);
            if($result['status'] == 'ACCEPTED') {
                $stockResponse['statusmessage'] = 'SUCCESS';
                $stockResponse['heading'] = '<h2 class="text-white">SUCCESS</h2>';
                $stockResponse['message'] = 'Stock Successfully Updated.';
            } else {
                $stockResponse['statusmessage'] = '<h2 class="text-white">ERROR</h2>';
                $stockResponse['message'] = 'There has been an error while updating Stock.<br>';
                if($result['issues']) {
                    foreach($result['issues'] as $issue) {
                        $stockResponse['message'] .= $issue['message'] . '<br>';
                        $stockResponse['message'] .= $issue['attribute_names'][0] . '<br>';
                    }
                }
            }
            return $stockResponse;
        } catch (Exception $e) {
            echo 'Exception when calling ListingsApi->patchListingsItem: ', $e->getMessage(), PHP_EOL;
        }
    }

    public function updateAmazonItemTitle($id, $title)
    {
        $seller_id = $this->settings->seller_id;
        $item = Item::where('id', $id)->first();
        $productType = 'PRODUCT';
        if ($item->country == 'Uk')
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
            if($result['status'] == 'ACCEPTED') {
                $titleResponse['statusmessage'] = 'SUCCESS';
                $titleResponse['heading'] = '<h2 class="text-white">SUCCESS</h2>';
                $titleResponse['message'] = 'Title Successfully Updated.';
            } else {
                $titleResponse['statusmessage'] = '<h2 class="text-white">ERROR</h2>';
                $titleResponse['message'] = 'There has been an error while updating Title.<br>';
                if($result['issues']) {
                    foreach($result['issues'] as $issue) {
                        $titleResponse['message'] .= $issue['message'] . '<br>';
                        $titleResponse['message'] .= $issue['attribute_names'][0] . '<br>';
                    }
                }
            }
            return $titleResponse;
        } catch (Exception $e) {
            echo 'Exception when calling ListingsApi->patchListingsItem: ', $e->getMessage(), PHP_EOL;
        }
    }

    public function updateAmazonItemPrice($id, $price, $currency)
    {
        $seller_id = $this->settings->seller_id;
        $item = Item::where('id', $id)->first();
        $productType = 'PRODUCT';
        if ($item->country == 'Uk')
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
                    ]],
                    'list_price' => [
                        [
                            'schedule' => [
                                [
                                    'value_with_tax' => $item->price
                                ]
                            ]
                        ]
                    ],
                    'uvp_list_price' => [
                        [
                            'schedule' => [
                                [
                                    'value_with_tax' => $item->price
                                ]
                            ]
                        ]
                    ]
                ]]
            ]];
        $body->setPatches(($patches));
        try {
            $result = $apiInstance->patchListingsItem($seller_id, $item->sku, $mpIds, $body, $issue_locale);
            if($result['status'] == 'ACCEPTED') {
                $priceResponse['statusmessage'] = 'SUCCESS';
                $priceResponse['heading'] = '<h2 class="text-white">SUCCESS</h2>';
                $priceResponse['message'] = 'Price Successfully Updated.';
            } else {
                $priceResponse['statusmessage'] = '<h2 class="text-white">ERROR</h2>';
                $priceResponse['message'] = 'There has been an error while updating price.<br>';
                if($result['issues']) {
                    foreach($result['issues'] as $issue) {
                        $priceResponse['message'] .= $issue['message'] . '<br>';
                        $priceResponse['message'] .= $issue['attribute_names'][0] . '<br>';
                    }
                }
            }
            //$this->uploadUpdateOffer($item);
            return $priceResponse;
        } catch (Exception $e) {
            echo 'Exception when calling ListingsApi->patchListingsItem: ', $e->getMessage(), PHP_EOL;
        }
    }

    public function updateAmazonSalePrice($id, $startDate, $endDate, $saleprice, $currency)
    {
        $seller_id = $this->settings->seller_id;
        $item = Item::where('id', $id)->first();
        $productType = 'PRODUCT';
        if ($item->country == 'Uk')
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
            if($result['status'] == 'ACCEPTED') {
                $saleReponse['statusmessage'] = 'SUCCESS';
                $saleReponse['heading'] = '<h2 class="text-white">SUCCESS</h2>';
                $saleReponse['message'] = 'Sale Price Successfully Updated.';
            } else {
                $saleReponse['statusmessage'] = '<h2 class="text-white">ERROR</h2>';
                $saleReponse['message'] = 'There has been an error while updating sale price.<br>';
                if($result['issues']) {
                    foreach($result['issues'] as $issue) {
                        $saleReponse['message'] .= $issue['message'] . '<br>';
                        $saleReponse['message'] .= $issue['attribute_names'][0] . '<br>';
                    }
                }
            }
            return $saleReponse;
        } catch (Exception $e) {
            echo 'Exception when calling ListingsApi->patchListingsItem: ', $e->getMessage(), PHP_EOL;
        }
    }

    public function uploadUpdateOffer($item)
    {
        if ($item->country == 'Uk') {
            $mpIds = 'A1F83G8C2ARO7P';
        }
        
        $offers = [[
            'marketplace_id' => ''. $mpIds .'',
            'offer_type' => 'B2C',
            'price' => [
                'currency_code' => ''. $item->currency_code .'',
                'amount' => $item->price
            ]
        ]];
        $issue_locale = 'en_US';
        $seller_id = $this->settings->seller_id;
        $marketplace_ids = $mpIds;
        $apiInstance = new ListingsApi($this->config);
        $body = new ListingsItemPatchRequest();
        $body->setProductType('PRODUCT');
        $patches = [
            [
                'op'    => 'replace',
                'path'  => 'offers',
                'value' => $offers
            ]
        ];
        dump($patches);
        $body->setPatches(($patches));
        try {
            $result = $apiInstance->patchListingsItem($seller_id, $item->sku, $mpIds, $body, $issue_locale);
            dump($result);
            if($result['status'] == 'ACCEPTED') {
                $offerResponse['statusmessage'] = 'SUCCESS';
                $offerResponse['heading'] = '<h2 class="text-white">SUCCESS</h2>';
                $offerResponse['message'] = 'Sale Price Successfully Updated.';
            } else {
                $offerResponse['statusmessage'] = '<h2 class="text-white">ERROR</h2>';
                $offerResponse['message'] = 'There has been an error while updating sale price.<br>';
                if($result['issues']) {
                    foreach($result['issues'] as $issue) {
                        $offerResponse['message'] .= $issue['message'] . '<br>';
                        $offerResponse['message'] .= $issue['attribute_names'][0] . '<br>';
                    }
                }
            }
            dump($offerResponse);
            return $offerResponse;
        } catch (Exception $e) {
            echo 'Exception when calling ListingsApi->patchListingsItem: ', $e->getMessage(), PHP_EOL;
        }
    }

    public function getListingRestrictions($asin, $country)
    {
        if ($country == 'Uk')
        {
            $mpIds = 'A1F83G8C2ARO7P';
        }

        $apiInstance = new ListingsRestrictionsApi($this->config);
        $marketplace_ids = $mpIds;
        $reason_locale = 'en_US';
        try {
            var_dump( $this->settings->seller_id);
            $result = $apiInstance->getListingsRestrictions($asin, $this->settings->seller_id, $mpIds, 'new_new', $reason_locale);
            dump($result);
        } catch (Exception $e) {
            echo 'Exception when calling ListingsRestrictionsApi->getListingsRestrictions: ', $e->getMessage(), PHP_EOL;
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