<?php

namespace Modules\TcbAmazonSync\Http\Controllers\Amazon;

use App\Abstracts\Http\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Route;
use App\Models\Common\Item as ComItem;
use Modules\TcbAmazonSync\Models\Amazon\Warehouse;
use Modules\TcbAmazonSync\Models\Amazon\Categories;
use Modules\TcbAmazonSync\Models\Amazon\SpApiSetting;
use Modules\TcbAmazonSync\Models\Amazon\Setting;
//Amazon SP API
use Thecodebunny\AmazonSpApi\Configuration;
use Thecodebunny\AmazonSpApi\Api\CatalogApi;
use Thecodebunny\AmazonSpApi\SellingPartnerOAuth;
use Thecodebunny\AmazonSpApi\SellingPartnerRegion;
use Thecodebunny\AmazonSpApi\SellingPartnerEndpoint;
//Amazon MWS API
use Thecodebunny\AmzMwsApi\AmazonOrderList;

class Main extends Controller
{
    
    private $config;
    private $company_id;
    private $country;
    private $settings;

    public function __construct(Request $request)
    {
        $this->country = Route::current()->originalParameter('country');
        $this->company_id = Route::current()->originalParameter('company_id');
    }

    public function dashboard()
    {
        
    }

    public function items()
    {

    }

    public function asinform($item_id)
    {
        $item = ComItem::where('id', $item_id)->first();
        $warehouses = Warehouse::all();
        $settings = Setting::first();
        $amzItem = \Modules\TcbAmazonSync\Models\Amazon\Item::where('item_id', $item_id)->first();
        if($amzItem->country = 'Uk') {
            $uk_item = true;
            $uk_category = Categories::where('uk_node_id', $amzItem->category_id)->first();
            if($uk_category) {$uk_cat_name = $uk_category->node_path;} else {$uk_cat_name = '';};
        } else {
            $uk_item == false;
        }

        return $this->response(
            'tcb-amazon-sync::amazon.asins.edit', 
            compact(
                'item', 
                'amzItem',
                'uk_item',
                'settings', 
                'uk_cat_name',
                'warehouses'
            )
        );
    }

}