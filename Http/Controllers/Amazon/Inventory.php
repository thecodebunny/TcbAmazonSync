<?php

namespace Modules\TcbAmazonSync\Http\Controllers\Amazon;

use DB;
use App\Abstracts\Http\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Route;
use Modules\TcbAmazonSync\Models\Amazon\Setting;
use Modules\TcbAmazonSync\Models\Amazon\SpApiSetting;
use Modules\TcbAmazonSync\Models\Amazon\MwsApiSetting;
use Modules\TcbAmazonSync\Models\Amazon\Reports;
use Modules\TcbAmazonSync\Models\Amazon\UkItem;
use Modules\Inventory\Models\Item as InventoryItem;
use App\Models\Common\Item;
use Illuminate\Support\Facades\Storage;
//Amazon SP API
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
    private $companyId;

    public function __construct(Request $request)
    {
        $settings = MwsApiSetting::where('company_id', $request->input('company_id'))->first();
        $this->companyId = $request->input('company_id');
        $this->config = [
            'merchantId' => $settings->merchant_id,
            'marketplaceId' => 'A1PA6795UKMFR9',
            'keyId' => $settings->key_id,
            'secretKey' => $settings->secret_key,
            'amazonServiceUrl' => 'https://mws-eu.amazonservices.com/',
        ];
    }

    public function mwsInventoryRequest()
    {
        
        $amz = new AmazonReportRequest($this->config);
        $amz->setReportType('_GET_MERCHANT_LISTINGS_ALL_DATA_');
        $amz->setCustomReport(1);
        $sDate = date(strtotime("-3 months"));
        $eDate = time();
        $amz->setTimeLimits($sDate, $eDate);
        $report = $amz->requestReport();
        $xml = simplexml_load_string($report);

        $result = $xml->RequestReportResult->ReportRequestInfo;
        print_r($result);

        $dbReport = new Reports;
        $dbReport->report_type = '_GET_MERCHANT_LISTINGS_ALL_DATA_';
        $dbReport->status = $result->ReportProcessingStatus;
        $dbReport->request_id = $result->ReportRequestId;

        $dbReport->save();

        //sleep(300);

        //$this->getListingReport($dbReport->id,$dbReport->request_id);

    }

    public function cronGetListingReport()
    {
        $dbReports = DB::table('amazon_reports')
        ->whereNull('generated_report_id')
        ->get();
        var_dump($dbReports);
        $amz = new AmazonReportRequestList($this->config);
        $amz->setReportTypes('_GET_MERCHANT_LISTINGS_ALL_DATA_');
        foreach($dbReports as $dbReport) {
            var_dump($dbReport);
            $amz->setRequestIds($dbReport->request_id);
            $report = $amz->fetchRequestList();
            $xml = simplexml_load_string($report);
            $reportArray = $this->xml2array($xml);
            $id = $reportArray['GetReportRequestListResult']['ReportRequestInfo']['GeneratedReportId'];

            $reportinDb = Reports::where('id', $dbReport->id)->first();
            $reportinDb->status = $reportArray['GetReportRequestListResult']['ReportRequestInfo']['ReportProcessingStatus'];
            $reportinDb->generated_report_id = $reportArray['GetReportRequestListResult']['ReportRequestInfo']['GeneratedReportId'];
            $reportinDb->save();

            var_dump($id);
            $this->getListingReport($id,$dbReport->request_id);
        }
        
    }

    public function getListingReport($id,$request_id)
    {
        $reportId = Reports::where('request_id', $request_id)->first();
            $amz = new AmazonReport($this->config);
            $amz->setReportId((int)$id);
            $report = $amz->fetchReport();
            //$xml = simplexml_load_string($report);
            echo '<pre>';
            print_r($report);
            $date = date("Y/m/d");
            var_dump($date);
                //$path = public_path('reports/inventory/'. $date .'/' .$id);
                $path = Storage::disk('public')->put('reports/inventory/'. $date .'/' .$id . '.txt', "\xEF\xBB\xBF" . $report['body']);
                //$amz->saveReport($path);
                var_dump($path);
        
    }

    public function processInventory(Request $request)
    {

        $date = date("Y/m/d");
        $disk = Storage::disk('public');
        $files = $disk->files('reports/inventory/'.$date.'/');
        $settings = Setting::where('company_id', $request->input('company_id'))->first();

        $fileData = collect();
        foreach($files as $file) {
            $fileData->push([
                'file' => $file,
                'date' => $disk->lastModified($file)
            ]);
        }
        $newest = $fileData->sortByDesc('date')->first();
        $content = file_get_contents(public_path($newest['file']));
        $allItems = [];
        $lines = explode(PHP_EOL, $content);
        $l = 0;
        foreach($lines as $line) {
            $allItems[$l] = explode("\t", $line);
            $l++;
        }
        $i = 0;
        dump($allItems[0]);
        $allItems = array_slice($allItems, 1);
        foreach ($allItems as $item) {
            if($item[0] !== 'item-name') {
                $this->createUpdateAmazonItem($this->companyId, $item, $settings->default_warehouse);    
            }
        }
    }
    public function createUpdateAmazonItem($companyId, $item, $defaultWarehouse = NULL)
    {
        //dump($this->companyId);
        dump($item);
        if ($item && !empty($item) && $item[0] !== '') {
            $dbAsin = UkItem::where('asin', $item[16])->first();
            if ($dbAsin && !empty($dbAsin)) {
                $com_item_id = $dbAsin->com_item_id;
                $item_id = $dbAsin->item_id;
                //dump($item_id);
            } else {
                $dbAsin = new UkItem;
                $com_item_id = $this->createUpdateCommonItem($this->companyId, $item);
                $item_id = $this->createUpdateInventoryItem($this->companyId, $com_item_id, $item);
                //dump($item_id);
            }
            dump($item_id);

            $dbAsin->item_id = $item_id;
            $dbAsin->com_item_id = $com_item_id;
            $dbAsin->enable = 'on';
            $dbAsin->amazon_status = $item[28];
            $dbAsin->ean = $item[22];
            $dbAsin->asin = $item[16];
            $dbAsin->sku = $item[3];
            if ( $defaultWarehouse ) {
                $dbAsin->warehouse = $defaultWarehouse;
            } else {
                $dbAsin->warehouse = 1;
            }
            //$dbAsin->sale_price = $item[28];
            if ($item[4] && !empty($item[4])) {
                $dbAsin->price = $item[4];
            } else {
                $dbAsin->price = 0;
            }
            $dbAsin->title = htmlspecialchars($item[0]);
            $dbAsin->description = htmlspecialchars($item[1]);
            $dbAsin->quantity = (int) $item[5];
            $dbAsin->save();
        }
    }

    public function createUpdateCommonItem($companyId, $item)
    {
        $dbItem = Item::where('uk_asin', $item[16])->first();
        if (!$dbItem || empty($dbItem)) {
            $dbItem = new Item;
        }
        $dbItem->company_id = $companyId;
        $dbItem->name = htmlspecialchars($item[0]);
        $dbItem->description = htmlspecialchars($item[1]);
        $dbItem->sku = $item[3];
        if ($item[4] && !empty($item[4])) {
            $dbItem->sale_price = $item[4];
        } else {
            $dbItem->sale_price = 0;
        }
        $dbItem->quantity = (int) $item[5];
        $dbItem->purchase_price = 0;
        $dbItem->uk_asin = $item[16];
        $dbItem->save();
        return $dbItem->id;
    }

    public function createUpdateInventoryItem($companyId, $com_item_id, $item)
    {
        $dbItem = InventoryItem::where('uk_asin', $item[16])->first();
        if (!$dbItem || empty($dbItem)) {
            $dbItem = new InventoryItem;
        }
        $dbItem->company_id = $companyId;
        $dbItem->item_id = $com_item_id;
        $dbItem->sku = $item[3];
        $dbItem->opening_stock = (int) $item[5];
        $dbItem->default_opening_stock = (int) $item[5];
        $dbItem->opening_stock_value = (int) $item[5];
        $dbItem->default_opening_stock_value = (int) $item[5];
        $dbItem->uk_asin = $item[16];
        $dbItem->save();
        return $dbItem->id;
    }

    public function uploadAmazonItem()
    {
        $items = InventoryItem::all();
        foreach($items as $item) {
            if ($item) {
                $amzItem = UkItem::where('item_id', $item->id)->first();
                if (! $amzItem || empty($amzItem)) {
                    return;
                } else {
                    
                }
            }
        }
    }

    public function xml2array( $xmlObject, $out = array () )
    {
        foreach ( (array) $xmlObject as $index => $node )
            $out[$index] = ( is_object ( $node ) ) ? $this->xml2array ( $node ) : $node;
    
        return $out;
    }

}