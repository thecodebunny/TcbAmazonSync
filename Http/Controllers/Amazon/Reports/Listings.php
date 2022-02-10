<?php

namespace Modules\TcbAmazonSync\Http\Controllers\Amazon\Reports;

use DebugBar\DebugBar;
use App\Abstracts\Http\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

//Common
use App\Models\Common\Item;

//Module TCB Amazon Sync
use Modules\TcbAmazonSync\Models\Amazon\Item as AmzItem;
use Modules\TcbAmazonSync\Models\Amazon\Report as AmzReport;
use Modules\TcbAmazonSync\Models\Amazon\SpApiSetting;
use Modules\TcbAmazonSync\Models\Amazon\MwsApiSetting;
use Modules\TcbAmazonSync\Http\Controllers\Amazon\Xml;
use Modules\TcbAmazonSync\Http\Controllers\Amazon\SpApi;


//Amazon SP API
use Thecodebunny\SpApi\Endpoint;
use Thecodebunny\SpApi\ReportType;
use Thecodebunny\SpApi\Configuration;
use Thecodebunny\SpApi\Api\ReportsApi;
use Thecodebunny\SpApi\Model\Reports\CreateReportSpecification;

class Listings extends Controller
{

    private $country;
    private $config;
    private $settings;
    private $companyId;
    private $request;
    private $mpIds;

    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->country = Route::current()->originalParameter('country');
        $this->companyId = Route::current()->originalParameter('company_id');
        $this->settings = SpApiSetting::where('company_id',$this->companyId )->first();
        if ($this->country == 'Uk') {
            $endpoint = Endpoint::EU;
            $this->mpIds = ['A1F83G8C2ARO7P'];
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

    public function createInventoryReport()
    {
        
        $reportType = ReportType::GET_MERCHANT_LISTINGS_ALL_DATA;
        $apiInstance = new ReportsApi($this->config);
        $body = new CreateReportSpecification();
        $body->setReportType($reportType['name']);
        $body->setDataStartTime(date('c', strtotime('-30 days')));
        $body->setMarketplaceIds($this->mpIds);
        dump($body);
        try {
            $result = $apiInstance->createReport($body);
            $dbReport = AmzReport::where('report_id', $result->getReportId())->first();
            if (! $dbReport || empty($dbReport)) {
                $dbReport = new AmzReport;
            }
            $dbReport->report_id = $result->getReportId();
            $dbReport->report_type = $reportType['name'];
            $dbReport->created_from = 'SP API';
            $dbReport->save();
            $this->getReport($result->getReportId(), $dbReport);
        } catch (Exception $e) {
            echo 'Exception when calling ReportsApi->createReport: ', $e->getMessage(), PHP_EOL;
        }

    }

    public function getReport($id, $dbReport)
    {
        $apiInstance = new ReportsApi($this->config);
        
        try {
            $result = $apiInstance->getReport($id);
            if ($result->getProcessingStatus() !==  'DONE') {
                $dbReport->status = $result->getProcessingStatus();
                $dbReport->report_start_time = $result->getDataStartTime();
                $dbReport->save();
                sleep(180);
                $this->getReport($id, $dbReport);
            } else {
                $dbReport->status = $result->getProcessingStatus();
                $dbReport->report_start_time = $result->getDataStartTime();
                $dbReport->save();
                $dbReport->report_document_id = $result->getReportDocumentId();
                $dbReport->save();
                $this->getDocument($result->getReportDocumentId(), $result->getReportType(), $dbReport);
            }
            echo 'getReport()';
            dump($result);
        } catch (Exception $e) {
            echo 'Exception when calling ReportsApi->getReport: ', $e->getMessage(), PHP_EOL;
        }
    }

    public function getDocument($id, $type, $dbReport)
    {
        $apiInstance = new ReportsApi($this->config);
        $report_document_id = $id;
        $report_type = $type;

        try {
            $result = $apiInstance->getReportDocument($report_document_id, $report_type);
            $fileName = $dbReport->report_id . '.txt';
            $folder = '/reports/listings/'. $this->country .'/' . date("Y-m-d") . '/' . $fileName;
            $content = file_get_contents($result->getUrl());
            Storage::disk('public')->put($folder, $content, 'public');
            $dbReport->directory = $folder;
            $dbReport->save();
            dump($result);
        } catch (Exception $e) {
            echo 'Exception when calling ReportsApi->getReportDocument: ', $e->getMessage(), PHP_EOL;
        }
    }

    public function readDoc($id)
    {
        $report = AmzReport::where('id', $id)->first();
        $directory = $report->directory;
        $content = Storage::disk('public')->get($directory);
        $listings = explode(PHP_EOL, $content);
        $listings = array_slice($listings, 1, -1);
        foreach($listings as $listing) {
            $item = explode("\t", $listing);
            dump($item);
            $dbItem = AmzItem::where('country', $this->country)->where('asin', $item[16])->where('sku', $item[3])->first();
            if (! $dbItem || empty($dbItem)) {
                $this->createNewCommonItem($item);
            }
        }
    }

    public function createNewCommonItem($item)
    {
        $cItem = new Item;
        $cItem->company_id = $this->companyId;
        $cItem->name = htmlspecialchars($item[0]);

        if($item[5] && !empty($item[4])) {
            $cItem->sale_price = $item[4];
        } else {
            $cItem->sale_price = 0;
        }
        
        $cItem->purchase_price = 0;

        if($item[5] && !empty($item[5])) {
            $cItem->quantity = $item[5];
        } else {
            $cItem->quantity = 0;
        }

        $cItem->category_id = 5;
        $cItem->save();
        $amzItem = AmzItem::where('item_id', $cItem->id)->first();
        if (! $amzItem || empty($amzItem)) {
            $amzItem = new AmzItem;
        }
        $amzItem->country = $this->country;
        $amzItem->company_id = $this->companyId;
        $amzItem->item_id = $cItem->id;
        $amzItem->sku = $item[3];
        $amzItem->asin = $item[16];
        $amzItem->title = $item[0];
        if($item[5] && !empty($item[5])) {
            $amzItem->quantity = $item[5];
        } else {
            $amzItem->quantity = 0;
        }

        if($item[5] && !empty($item[4])) {
            $cItem->price = $item[4];
        } else {
            $cItem->price = 0;
        }
        
        $amzItem->save();
        $this->createUpdateAmzItem($amzItem->id, $this->country);
    }

    public function createUpdateAmzItem($id, $country)
    {
        $spApi = new SpApi($this->request);
        $spApi->getAmzItem($id, $country);
    }

}