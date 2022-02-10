<?php

namespace Modules\TcbAmazonSync\Http\Controllers\Amazon\Feeds;

use DB;
use App\Abstracts\Http\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Modules\TcbAmazonSync\Models\Amazon\Feed;
use Modules\TcbAmazonSync\Models\Amazon\Item as AmzItem;
use Modules\TcbAmazonSync\Models\Amazon\SpApiSetting;
use Modules\TcbAmazonSync\Models\Amazon\MwsApiSetting;
use Modules\TcbAmazonSync\Http\Controllers\Amazon\SpApi;
use Modules\TcbAmazonSync\Http\Controllers\Amazon\Xml;

//Amazon SP API
use Thecodebunny\SpApi\Document;
use Thecodebunny\SpApi\FeedType;
use Thecodebunny\SpApi\Endpoint;
use Thecodebunny\SpApi\Configuration;
use Thecodebunny\SpApi\Api\FeedsApi;
use Thecodebunny\SpApi\Api\CatalogApi;
use Thecodebunny\SpApi\SellingPartnerOAuth;
use Thecodebunny\SpApi\SellingPartnerRegion;
use Thecodebunny\SpApi\SellingPartnerEndpoint;
use Thecodebunny\SpApi\Model\Feeds\CreateFeedSpecification;
use Thecodebunny\SpApi\Model\Feeds\CreateFeedDocumentSpecification;

class Item extends Controller
{
    private $config;
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

    public function createProductFeedDocument($id)
    {
        $item = AmzItem::where('id', $id)->first();
        var_dump($id);
        if ($item->country == 'Uk')
        {
            $mpIds = ['A1F83G8C2ARO7P'];
        }
        $feedType = FeedType::POST_PRODUCT_DATA;
        $feedsApi = new FeedsApi($this->config);
        // Create feed document
        $createFeedDocSpec = new CreateFeedDocumentSpecification(['content_type' => $feedType['contentType']]);
        $feedDocumentInfo = $feedsApi->createFeedDocument($createFeedDocSpec);
        $feedDocumentId = $feedDocumentInfo->getFeedDocumentId();
        dump($feedDocumentInfo);

        $dbFeed = Feed::where('feed_document_id', $feedDocumentId)->first();
        if (! $dbFeed ) {
            $dbFeed = new Feed;
        }
        $dbFeed->feed_type = 'POST_PRODUCT_DATA';
        $dbFeed->feed_document_id = $feedDocumentInfo->getFeedDocumentId();
        $dbFeed->api_type = 'SP';
        $dbFeed->url = $feedDocumentInfo->getUrl();
        $dbFeed->country = $item->country;
        $dbFeed->save();
        
        $xml = new Xml;
        $feedContents = $xml->creatProductFeed($item, $this->settings->seller_id);
        dump($feedContents);
        $docToUpload = new Document($feedDocumentInfo, $feedType);
        $docToUpload->upload($feedContents);

        $this->createFeed($mpIds, $dbFeed, $item);
    }

    public function createFeed($mpIds, $dbFeed, $item)
    {
        $apiInstance = new FeedsApi($this->config);
        $body = new CreateFeedSpecification();
        $body->setFeedType($dbFeed->feed_type);
        $body->setMarketplaceIds($mpIds);
        $body->setInputFeedDocumentId($dbFeed->feed_document_id);

        try {
            $result = $apiInstance->createFeed($body);
            $dbFeed->feed_id = $result->getFeedId();
            $dbFeed->save();
            dump($result);
            $this->getFeed($dbFeed->feed_id, $item);
        } catch (Exception $e) {
            echo 'Exception when calling FeedsApi->createFeed: ', $e->getMessage(), PHP_EOL;
        }
    }

    public function getFeed($feedId, $item)
    {
        $dbFeed = Feed::where('feed_id', $feedId)->first();
        $apiInstance = new FeedsApi($this->config);
        $result = $apiInstance->getFeed($dbFeed->feed_id);
        //dump($result->getProcessingStatus());
        if ($result->getProcessingStatus() !== 'DONE') {
            $dbFeed->status = $result->getProcessingStatus();
            $dbFeed->save();
            sleep(60);
            $this->getFeed($dbFeed->feed_id, $item);
        } else {
            $dbFeed->status = $result->getProcessingStatus();
            $dbFeed->result_feed_document_id = $result->getResultFeedDocumentId();
            $dbFeed->save();
            $this->getFeedDocument($dbFeed, $item);
        }
        dump($result);
    }

    public function getFeedDocument($dbFeed, $item)
    {
        $apiInstance = new FeedsApi($this->config);
        $result = $apiInstance->getFeedDocument($dbFeed->result_feed_document_id);
        $dbFeed->result_feed_url = $result->getUrl();
        $dbFeed->save();
        
        echo 'feed doc';
        $xml = file_get_contents($result->getUrl());
        $xmlLoad = simplexml_load_string($xml);
        $encoded = json_encode($xmlLoad);
        $finalResult = json_decode($encoded);
        dump($finalResult);
        //$saleReponse['heading'] = '<h2 class="text-white">'. $finalResult['Message']['StatusCode'] .'</h2>';
        //$saleReponse['message'] = 'Images Uploaded : ' . $finalResult['Message']['ProcessingSummary']['MessagesProcessed'] .'<br>';
        //$saleReponse['message'] .= 'Images Succcessfully Uploaded : ' . $finalResult['Message']['ProcessingSummary']['MessagesSuccessful'] .'<br>';
        //$saleReponse['message'] .= 'Images With Error : ' . $finalResult['Message']['ProcessingSummary']['MessagesWithError'] .'<br>';
        //$saleReponse['message'] .= 'Images With Warning : ' . $finalResult['Message']['ProcessingSummary']['MessagesWithWarning'] .'<br>';
        $spApiController = new SpApi($this->request);
        if ($item->quantity) {
            $spApiController->updateAmazonItemStock($item->id, $item->quantity);
        }
        if ($item->price) {
            $spApiController->updateAmazonItemPrice($item->id, $item->price, $item->currency_code);
        }
        if ($item->sale_price) {
            $spApiController->updateAmazonSalePrice($item->id, $item->sale_start_date, $item->sale_end_date, $item->sale_price, $item->currency_code);
        }
        if ($item->main_picture || $item->picture_2 || $item->picture_3 || $item->picture_4 || $item->picture_5 || $item->picture_6 || $item->picture_7) {
            $imageController = new Image($this->request);
            $imageController->createImageFeedDocument($item->id);
        }
        //return $saleReponse;
        $response = [
            'message' => $finalResult
        ];
        return $response;
    }

}