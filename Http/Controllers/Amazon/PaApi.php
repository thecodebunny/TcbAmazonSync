<?php

namespace Modules\TcbAmazonSync\Http\Controllers\Amazon;

use App\Abstracts\Http\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;
use Modules\Inventory\Models\Item;
use Modules\Inventory\Models\Warehouse;
use Modules\TcbAmazonSync\Models\Amazon\Item as AmzItem;
use Modules\TcbAmazonSync\Models\Amazon\Asin as AmzAsin;
use Modules\TcbAmazonSync\Models\Amazon\Categories;
use Modules\TcbAmazonSync\Models\Amazon\PaApiSetting;

//PA API
use TheCodeBunny\PaApi\ApiException;
use TheCodeBunny\PaApi\Configuration;
use TheCodeBunny\PaApi\api\DefaultApi;
use TheCodeBunny\PaApi\GetItemsRequest;
use TheCodeBunny\PaApi\GetItemsResource;
use TheCodeBunny\PaApi\PartnerType;
use TheCodeBunny\PaApi\ProductAdvertisingAPIClientException;

class PaApi extends Controller
{

    public function fetchAllProducts(Request $request, $country)
    {
        $settings = PaApiSetting::where('company_id',Route::current()->originalParameter('company_id'))->first();
        if ($country == 'Uk') {
            $pTag = $settings->associate_tag_uk;
            $host = 'webservices.amazon.co.uk';
            $asins = AmzItem::where('company_id',Route::current()->originalParameter('company_id'))->where('country', 'Uk')->get()->toArray();
        }
        $config = new Configuration();
        $config->setAccessKey($settings->api_key);
        $config->setSecretKey($settings->api_secret_key);
        $partnerTag = $pTag;
        $config->setHost($host);
        $config->setRegion('eu-west-1');
        $apiInstance = new DefaultApi(
            new \GuzzleHttp\Client(), $config);
        $itemIds = array_column($asins, 'asin');
        $resources = array(
            GetItemsResource::BROWSE_NODE_INFOBROWSE_NODES,
            GetItemsResource::BROWSE_NODE_INFOBROWSE_NODESANCESTOR,
            GetItemsResource::BROWSE_NODE_INFOBROWSE_NODESSALES_RANK,
            GetItemsResource::BROWSE_NODE_INFOWEBSITE_SALES_RANK,
            GetItemsResource::IMAGESPRIMARYSMALL,
            GetItemsResource::IMAGESPRIMARYMEDIUM,
            GetItemsResource::IMAGESPRIMARYLARGE,
            GetItemsResource::IMAGESVARIANTSSMALL,
            GetItemsResource::IMAGESVARIANTSMEDIUM,
            GetItemsResource::IMAGESVARIANTSLARGE,
            GetItemsResource::ITEM_INFOBY_LINE_INFO,
            GetItemsResource::ITEM_INFOCONTENT_INFO,
            GetItemsResource::ITEM_INFOCONTENT_RATING,
            GetItemsResource::ITEM_INFOCLASSIFICATIONS,
            GetItemsResource::ITEM_INFOEXTERNAL_IDS,
            GetItemsResource::ITEM_INFOFEATURES,
            GetItemsResource::ITEM_INFOMANUFACTURE_INFO,
            GetItemsResource::ITEM_INFOPRODUCT_INFO,
            GetItemsResource::ITEM_INFOTECHNICAL_INFO,
            GetItemsResource::ITEM_INFOTITLE,
            GetItemsResource::ITEM_INFOTRADE_IN_INFO,
            GetItemsResource::OFFERSLISTINGSAVAILABILITYMAX_ORDER_QUANTITY,
            GetItemsResource::OFFERSLISTINGSAVAILABILITYMESSAGE,
            GetItemsResource::OFFERSLISTINGSAVAILABILITYMIN_ORDER_QUANTITY,
            GetItemsResource::OFFERSLISTINGSAVAILABILITYTYPE,
            GetItemsResource::OFFERSLISTINGSCONDITION,
            GetItemsResource::OFFERSLISTINGSCONDITIONSUB_CONDITION,
            GetItemsResource::OFFERSLISTINGSDELIVERY_INFOIS_AMAZON_FULFILLED,
            GetItemsResource::OFFERSLISTINGSDELIVERY_INFOIS_FREE_SHIPPING_ELIGIBLE,
            GetItemsResource::OFFERSLISTINGSDELIVERY_INFOIS_PRIME_ELIGIBLE,
            GetItemsResource::OFFERSLISTINGSDELIVERY_INFOSHIPPING_CHARGES,
            GetItemsResource::OFFERSLISTINGSIS_BUY_BOX_WINNER,
            GetItemsResource::OFFERSLISTINGSLOYALTY_POINTSPOINTS,
            GetItemsResource::OFFERSLISTINGSMERCHANT_INFO,
            GetItemsResource::OFFERSLISTINGSPRICE,
            GetItemsResource::OFFERSLISTINGSPROGRAM_ELIGIBILITYIS_PRIME_EXCLUSIVE,
            GetItemsResource::OFFERSLISTINGSPROGRAM_ELIGIBILITYIS_PRIME_PANTRY,
            GetItemsResource::OFFERSLISTINGSPROMOTIONS,
            GetItemsResource::OFFERSLISTINGSSAVING_BASIS,
            GetItemsResource::OFFERSSUMMARIESHIGHEST_PRICE,
            GetItemsResource::OFFERSSUMMARIESLOWEST_PRICE,
            GetItemsResource::OFFERSSUMMARIESOFFER_COUNT,
            GetItemsResource::PARENT_ASIN,
            GetItemsResource::RENTAL_OFFERSLISTINGSMERCHANT_INFO
        );

        $getItemsRequest = new GetItemsRequest();
        $getItemsRequest->setItemIds($itemIds);
        $getItemsRequest->setPartnerType(PartnerType::ASSOCIATES);
        $getItemsRequest->setPartnerTag($partnerTag);
        $getItemsRequest->setResources($resources);

        # Validating request
        $invalidPropertyList = $getItemsRequest->listInvalidProperties();
        $length = count($invalidPropertyList);
        if ($length > 0) {
            echo "Error forming the request", PHP_EOL;
            foreach ($invalidPropertyList as $invalidProperty) {
                echo $invalidProperty, PHP_EOL;
            }
            return;
        }

        # Sending the request
    try {
        $getItemsResponse = $apiInstance->getItems($getItemsRequest);
        $items = $this->parseResponse = $getItemsResponse->getItemsResult()->getItems();
        
        foreach ($items as $item)
        {
            $dbItem = AmzItem::where('company_id',Route::current()->originalParameter('company_id'))->where('country', 'Uk')->where('asin', $item->getAsin())->first();

            //Set Company ID for ASIN
            $dbItem->company_id = Route::current()->originalParameter('company_id');

            //Get & Set Browsnode ID
            $browseNodes = $item->getBrowseNodeInfo()->getBrowseNodes();
            foreach ($browseNodes as $node) {
                if (! $node->getChildren()) {
                    $dbItem->category_id = $node->getId();
                }
            }

            //Get & Set Images
            $images = $item->getImages();
            $mainImage = $images->getPrimary();
            $url = $mainImage->getLarge()->getUrl();
            $mainPic = file_get_contents($url);
            $mainName = basename($url);
            $picFolder = 'items/'. $country .'/'. $dbItem->asin . '/mainImage/' . $mainName;
            Storage::disk('public')->deleteDirectory('items/'. $country .'/'. $dbItem->asin . '/mainImage/');
            Storage::disk('public')->put($picFolder, $mainPic, 'public');
            $dbItem->main_picture = $picFolder;
            $variants = $images->getVariants();
            array_shift($variants);
            $i = 1;
            Storage::disk('public')->deleteDirectory('items/'. $country .'/'. $dbItem->asin . '/variants/');
            foreach ($variants as $i => $image) {
                $imageUrl = $image->getLarge()->getUrl();
                $image = file_get_contents($imageUrl);
                $imageName = basename($imageUrl);
                if ($i == 0) {
                    $imageFolder = 'items/'. $country .'/'. $dbItem->asin . '/variants/1-' .$imageName;
                    Storage::disk('public')->put($imageFolder, $image, 'public');
                    $dbItem->picture_1 = $imageFolder;
                }
                if ($i == 1) {
                    $imageFolder = 'items/'. $country .'/'. $dbItem->asin . '/variants/2-' .$imageName;
                    Storage::disk('public')->put($imageFolder, $image, 'public');
                    $dbItem->picture_2 = $imageFolder;
                }
                if ($i == 2) {
                    $imageFolder = 'items/'. $country .'/'. $dbItem->asin . '/variants/3-' .$imageName;
                    Storage::disk('public')->put($imageFolder, $image, 'public');
                    $dbItem->picture_3 = $imageFolder;
                }
                if ($i == 3) {
                    $imageFolder = 'items/'. $country .'/'. $dbItem->asin . '/variants/4-' .$imageName;
                    Storage::disk('public')->put($imageFolder, $image, 'public');
                    $dbItem->picture_4 = $imageFolder;
                }
                if ($i == 4) {
                    $imageFolder = 'items/'. $country .'/'. $dbItem->asin . '/variants/5-' .$imageName;
                    Storage::disk('public')->put($imageFolder, $image, 'public');
                    $dbItem->picture_5 = $imageFolder;
                }
                if ($i == 5) {
                    $imageFolder = 'items/'. $country .'/'. $dbItem->asin . '/variants/6-' .$imageName;
                    Storage::disk('public')->put($imageFolder, $image, 'public');
                    $dbItem->picture_6 = $imageFolder;
                }
                $i++;
            }

            //Get & Set Bullet Points
            $bulletPoints = $item->getItemInfo()->getFeatures()->getDisplayValues();
            if ($bulletPoints && !empty($bulletPoints)) {
                foreach ($bulletPoints as $i => $point) {
                    if ($i == 0) {
                        $dbItem->bullet_point_1 = $point;
                    }
                    if ($i == 1) {
                        $dbItem->bullet_point_2 = $point;
                    }
                    if ($i == 2) {
                        $dbItem->bullet_point_3 = $point;
                    }
                    if ($i == 3) {
                        $dbItem->bullet_point_4 = $point;
                    }
                    if ($i == 4) {
                        $dbItem->bullet_point_5 = $point;
                    }
                    if ($i == 5) {
                        $dbItem->bullet_point_6 = $point;
                    }
                }
            }

            //Get & Set Product Dimensions
            $dimensions = $item->getItemInfo()->getProductInfo()->getItemDimensions();
            if ($dimensions && !empty($dimensions)) {
                if ( $dimensions->getHeight()){
                    $dbItem->height = $dimensions->getHeight()->getDisplayValue();
                }
                if ( $dimensions->getLength()) {
                    $dbItem->length = $dimensions->getLength()->getDisplayValue();
                }
                if ( $dimensions->getWeight()) {
                    $dbItem->weight = $dimensions->getWeight()->getDisplayValue();
                }
                if ( $dimensions->getWidth()) {
                    $dbItem->width = $dimensions->getWidth()->getDisplayValue();
                }
            }

            //Get & Set Product Prices
            $offers = $item->getOffers();
            if ($offers && !empty($offers)) {
                $listings = $offers->getListings();
                foreach ($listings as $offer) {
                    if ($offer->getMerchantInfo()->getName() == 'zoomyo' || 
                        $offer->getMerchantInfo()->getName() == 'meateor' || 
                        $offer->getMerchantInfo()->getName() == 'Zoomyo' || 
                        $offer->getMerchantInfo()->getName() == 'Meateor') {
                           $dbItem->price = $offer->getPrice()->getAmount();
                        }
                }
                $summaries = $offers->getSummaries();
                if ($summaries && !empty($summaries)) {
                    if ($summaries[0]->getOfferCount() > 1) {
                        $dbItem->otherseller_warning = 1;
                    }
                }
            }

            dump($dbItem);

            //Save Asin
            $dbItem->save();
            dump($item);
        }

        } catch (ApiException $exception) {
            echo "Error calling PA-API 5.0!", PHP_EOL;
            echo "HTTP Status Code: ", $exception->getCode(), PHP_EOL;
            echo "Error Message: ", $exception->getMessage(), PHP_EOL;
            if ($exception->getResponseObject() instanceof ProductAdvertisingAPIClientException) {
                $errors = $exception->getResponseObject()->getErrors();
                foreach ($errors as $error) {
                    echo "Error Type: ", $error->getCode(), PHP_EOL;
                    echo "Error Message: ", $error->getMessage(), PHP_EOL;
                }
            } else {
                echo "Error response body: ", $exception->getResponseBody(), PHP_EOL;
            }
        } catch (Exception $exception) {
            echo "Error Message: ", $exception->getMessage(), PHP_EOL;
        }
    }

    public function parseResponse($items)
    {
        $mappedResponse = array();
        foreach ($items as $item) {
            $mappedResponse[$item->getASIN()] = $item;
        }
        return $mappedResponse;
    }

}