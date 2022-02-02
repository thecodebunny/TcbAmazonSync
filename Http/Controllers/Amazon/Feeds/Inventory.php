<?php

namespace Modules\TcbAmazonSync\Http\Controllers\Amazon\Feeds;

use DB;
use App\Abstracts\Http\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Route;
use Modules\TcbAmazonSync\Models\Amazon\Feed;
use Modules\TcbAmazonSync\Models\Amazon\Item;
use Modules\TcbAmazonSync\Models\Amazon\SpApiSetting;
use Illuminate\Support\Facades\Storage;
//Amazon SP API
use Thecodebunny\AmazonSpApi\FeedType;
use Thecodebunny\AmazonSpApi\Configuration;
use Thecodebunny\AmazonSpApi\Api\CatalogApi;
use Thecodebunny\AmazonSpApi\SellingPartnerOAuth;
use Thecodebunny\AmazonSpApi\SellingPartnerRegion;
use Thecodebunny\AmazonSpApi\SellingPartnerEndpoint;
//Amazon MWS API
use Thecodebunny\AmzMwsApi\AmazonReport;
use Thecodebunny\AmzMwsApi\AmazonReportRequest;
use Thecodebunny\AmzMwsApi\AmazonReportRequestList;
use Thecodebunny\AmzMwsApi\AmazonInventoryList;

class Inventory extends Controller
{

    private $config;

    public function __construct(Request $request)
    {
        $settings = MwsApiSetting::where('company_id', Route::current()->parameter('company_id'))->first();
        $this->config = [
            'merchantId' => $settings->merchant_id,
            'marketplaceId' => 'A1PA6795UKMFR9',
            'keyId' => $settings->key_id,
            'secretKey' => $settings->secret_key,
            'amazonServiceUrl' => 'https://mws-eu.amazonservices.com/',
        ];
    }

    public function createStockFeedDocument($id, $country, $qty)
    {
        $item = Item::where('id', $id)->first();
        if ($item->country == 'Uk')
        {
            $mpIds = ['A1F83G8C2ARO7P'];
        }
        $feedType = FeedType::POST_INVENTORY_AVAILABILITY_DATA;
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
        $dbFeed->feed_type = 'POST_INVENTORY_AVAILABILITY_DATA';
        $dbFeed->feed_document_id = $feedDocumentInfo->getFeedDocumentId();
        $dbFeed->api_type = 'SP';
        $dbFeed->url = $feedDocumentInfo->getUrl();
        $dbFeed->country = $country;
        $dbFeed->save();
        
        $xml = new Xml;
        $feedContents = $xml->creatSingleInventoryFeed($item->sku, $qty, $this->settings->seller_id);
        $docToUpload = new Document($feedDocumentInfo, $feedType);
        $docToUpload->upload($feedContents);

        $this->createFeed($mpIds, $dbFeed);
    }

    public function createFeed($mpIds, $dbFeed)
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
            $this->getFeed($dbFeed->feed_id);
        } catch (Exception $e) {
            echo 'Exception when calling FeedsApi->createFeed: ', $e->getMessage(), PHP_EOL;
        }
    }

    public function getFeed($feedId)
    {
        $dbFeed = Feed::where('feed_id', $feedId)->first();
        $apiInstance = new FeedsApi($this->config);
        $result = $apiInstance->getFeed($dbFeed->feed_id);
        //dump($result->getProcessingStatus());
        if ($result->getProcessingStatus() !== 'DONE') {
            $dbFeed->status = $result->getProcessingStatus();
            $dbFeed->save();
            sleep(180);
            $this->getFeed($dbFeed->feed_id);
        } else {
            $dbFeed->status = $result->getProcessingStatus();
            $dbFeed->result_feed_document_id = $result->getResultFeedDocumentId();
            $dbFeed->save();
            $this->getFeedDocument($dbFeed);
        }
        //dump($result);
    }

    public function getFeedDocument($dbFeed)
    {
        $apiInstance = new FeedsApi($this->config);
        $result = $apiInstance->getFeedDocument($dbFeed->result_feed_document_id);
        $dbFeed->result_feed_url = $result->getUrl();
        $dbFeed->save();
        echo 'feed doc';
        dump((file_get_contents($result->getUrl())));
    }

}