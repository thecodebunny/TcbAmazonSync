<?php

namespace Modules\TcbAmazonSync\Http\Controllers\Amazon;

use App\Abstracts\Http\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Inventory\Models\Item;
use Modules\Inventory\Models\Warehouse;
use Modules\Inventory\Models\Amazon\Item as AmzItem;
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

class PaController extends Controller
{

    public function fetchAllProducts(Request $request, $country)
    {
        $settings = PaApiSetting::where($request->input('company_id'))->first();
        $config = new Configuration();
        $config->setAccessKey($settings->api_key);
        $config->setSecretKey($settings->api_secret_key);
        $partnerTag = $settings->associate_tag_uk;
        $config->setHost('webservices.amazon.co.uk');
        $config->setRegion('eu-west-1');
        $apiInstance = new DefaultApi(
            new \GuzzleHttp\Client(), $config);
        $itemIds = array("B091253FBD", "B08FMJPN5C");

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
        dump($items);
        foreach ($items as $item)
        {
            if ($country == 'Uk') {
                $amzItem = AmzItem::where('uk_item', $item->getAsin())->first();
                $dbAsin = UkItem::where('item_id', $amzItem->inv_item_id)->first();
            }



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