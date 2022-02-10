<?php

namespace Modules\TcbAmazonSync\Http\Controllers\Amazon\Feeds;

use DB;
use App\Abstracts\Http\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Modules\TcbAmazonSync\Models\Amazon\Feed;
use Modules\TcbAmazonSync\Http\Controllers\Amazon\Xml;
use Modules\TcbAmazonSync\Models\Amazon\SpApiSetting;
use Modules\TcbAmazonSync\Models\Amazon\MwsApiSetting;
use Modules\TcbAmazonSync\Models\Amazon\Order as AmzOrder;
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

class Order extends Controller
{
    private $config;

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

    public function createShippingConfirmationFeedDocument($country, $amzOrderId, $tId, $tId2, $tId3, $tId4, $tId5, $id, $carrier)
    {
        if ($country == 'Uk')
        {
            $mpIds = ['A1F83G8C2ARO7P'];
        }
        
        $xml = new Xml;
        $shippingDate = date('Y-m-d\TH:i:sP', strtotime('now'));
        $feedContents = $xml->createPricingFeed($country, $amzOrderId, $tId, $tId2, $tId3, $tId4, $tId5, $shippingDate, $carrier, $this->settings->seller_id);

        //return $feedContents;
        $feedType = FeedType::POST_ORDER_FULFILLMENT_DATA;
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
        $dbFeed->feed_type = 'POST_ORDER_FULFILLMENT_DATA';
        $dbFeed->feed_document_id = $feedDocumentInfo->getFeedDocumentId();
        $dbFeed->api_type = 'SP';
        $dbFeed->url = $feedDocumentInfo->getUrl();
        $dbFeed->country = $item->country;
        $dbFeed->save();

        dump($feedContents);

        $docToUpload = new Document($feedDocumentInfo, $feedType);
        $docToUpload->upload($feedContents);

        $this->createFeed($id, $tId, $tId2, $tId3, $tId4, $tId5, $mpIds, $dbFeed);
    }

    public function createFeed($id, $tId, $tId2, $tId3, $tId4, $tId5, $mpIds, $dbFeed)
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
            $this->getFeed($id, $tId, $tId2, $tId3, $tId4, $tId5, $dbFeed->feed_id);
        } catch (Exception $e) {
            echo 'Exception when calling FeedsApi->createFeed: ', $e->getMessage(), PHP_EOL;
        }
    }

    public function getFeed($id, $tId, $tId2, $tId3, $tId4, $tId5, $feedId)
    {
        $dbFeed = Feed::where('feed_id', $feedId)->first();
        $apiInstance = new FeedsApi($this->config);
        $result = $apiInstance->getFeed($dbFeed->feed_id);
        //dump($result->getProcessingStatus());
        if ($result->getProcessingStatus() !== 'DONE') {
            $dbFeed->status = $result->getProcessingStatus();
            $dbFeed->save();
            sleep(60);
            $this->getFeed($id, $tId, $tId2, $tId3, $tId4, $tId5, $dbFeed->feed_id);
        } else {
            $dbFeed->status = $result->getProcessingStatus();
            $dbFeed->result_feed_document_id = $result->getResultFeedDocumentId();
            $dbFeed->save();
            $this->getFeedDocument($id, $tId, $tId2, $tId3, $tId4, $tId5, $dbFeed);
        }
        //dump($result);
    }

    public function getFeedDocument($id, $tId, $tId2, $tId3, $tId4, $tId5, $dbFeed)
    {
        $apiInstance = new FeedsApi($this->config);
        $result = $apiInstance->getFeedDocument($dbFeed->result_feed_document_id);
        $dbFeed->result_feed_url = $result->getUrl();
        $dbFeed->save();

        $dbOrder = AmzOrder::where('id', $id)->first();
        $dbOrder->tracking_id_1 = $tId;
        if ($tId2 !== NULL) {
            $dbOrder->tracking_id_2 = $tId2;
        }
        if ($tId3 !== NULL) {
            $dbOrder->tracking_id_3 = $tId3;
        }
        if ($tId4 !== NULL) {
            $dbOrder->tracking_id_4 = $tId4;
        }
        if ($tId5 !== NULL) {
            $dbOrder->tracking_id_5 = $tId5;
        }
        $dbOrder->order_status = 'Shipped';
        $dbOrder->save();
        
        echo 'feed doc';
        $xml = file_get_contents($result->getUrl());
        $xmlLoad = simplexml_load_string($xml);
        $encoded = json_encode($xmlLoad);
        $finalResult = json_decode($encoded);
        dump($finalResult->getMessage());
        $response = [
            'message' => $finalResult
        ];
    }
}