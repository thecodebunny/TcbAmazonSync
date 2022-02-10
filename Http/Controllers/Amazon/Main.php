<?php

namespace Modules\TcbAmazonSync\Http\Controllers\Amazon;

use DB;
use App\Abstracts\Http\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Route;
use App\Models\Common\Item as ComItem;
use Modules\TcbAmazonSync\Models\Amazon\Brand;
use Modules\TcbAmazonSync\Models\Amazon\Setting;
use Modules\TcbAmazonSync\Models\Amazon\Warehouse;
use Modules\TcbAmazonSync\Models\Amazon\Categories;
use Modules\TcbAmazonSync\Models\Amazon\ProductType;
use Modules\TcbAmazonSync\Models\Amazon\SpApiSetting;
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
        return view('tcb-amazon-sync::amazon.dashboard');
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
        $pTypes = ProductType::all();
        $brands = Brand::all();
        $currencies = \App\Models\Setting\Currency::all();
        if($amzItem->country = 'Uk') {
            $uk_item = true;
            $uk_type = Categories::where('uk_node_id', $amzItem->category_id)->first();
            if($uk_type) {$uk_cat_name = $uk_type->node_path;} else {$uk_cat_name = '';};
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
                'brands', 
                'uk_cat_name',
                'warehouses',
                'pTypes',
                'currencies'
            )
        );
    }

    public function ptIndex()
    {
        return view('tcb-amazon-sync::amazon.producttypes.index');
    }

    public function productTypeDataTable(Request $request)
    {
        $columns = array( 
            0 => 'id',
            3 => 'name',
            1 => 'uk',
            2 => 'de',
            4 => 'fr',
            5 => 'it',
            6 => 'es',
            7 => 'se',
            8 => 'nl',
            9 => 'pl',
            10 => 'us',
            11 => 'ca'
        );

        $productTypes = DB::table('amazon_product_types');

        $totalData = $productTypes->count();

        $totalFiltered = $totalData; 

        $orderColumn = $request->input( 'order.0.column' );
        $orderDirection = $request->input( 'order.0.dir' );
        $length = $request->input( 'length' );
        $start = $request->input( 'start' );

        if ($request->has( 'search' )) {
            if ($request->input( 'search.value' ) != '') {
                $searchTerm = $request->input( 'search.value' );
                
                $productTypes->where( 'amazon_product_types.name', 'Like', '%' . $searchTerm . '%' );
            }
        }
        
        if ($request->has( 'order' )) {
            if ($request->input( 'order.0.column' ) != '') {
                $productTypes->orderBy( $columns[intval( $orderColumn )], $orderDirection );
            }
        }

        $totalFiltered = $productTypes->count();

        config()->set('database.connections.mysql.strict', false);
        $productTypes = $productTypes->get();
        $productTypes = $productTypes->skip($start)->take($length);

        $data = array();

        if(!empty($productTypes))
        {
            foreach ($productTypes as $type)
            {

                if ($type->is_uk) {
                    $uk = '<span class="btn btn-success btn-sm "><i class="fas fa-check-circle"></i></span>';
                } else {
                    $uk = '<span class="btn btn-danger btn-sm "><i class="fas fa-times-circle"></i></span>';
                }
                if ($type->is_de) {
                    $de = '<span class="btn btn-success btn-sm "><i class="fas fa-check-circle"></i></span>';
                } else {
                    $de = '<span class="btn btn-danger btn-sm "><i class="fas fa-times-circle"></i></span>';
                }
                if ($type->is_fr) {
                    $fr = '<span class="btn btn-success btn-sm "><i class="fas fa-check-circle"></i></span>';
                } else {
                    $fr = '<span class="btn btn-danger btn-sm "><i class="fas fa-times-circle"></i></span>';
                }
                if ($type->is_it) {
                    $it = '<span class="btn btn-success btn-sm "><i class="fas fa-check-circle"></i></span>';
                } else {
                    $it = '<span class="btn btn-danger btn-sm "><i class="fas fa-times-circle"></i></span>';
                }
                if ($type->is_es) {
                    $es = '<span class="btn btn-success btn-sm "><i class="fas fa-check-circle"></i></span>';
                } else {
                    $es = '<span class="btn btn-danger btn-sm "><i class="fas fa-times-circle"></i></span>';
                }
                if ($type->is_se) {
                    $se = '<span class="btn btn-success btn-sm "><i class="fas fa-check-circle"></i></span>';
                } else {
                    $se = '<span class="btn btn-danger btn-sm "><i class="fas fa-times-circle"></i></span>';
                }
                if ($type->is_nl) {
                    $nl = '<span class="btn btn-success btn-sm "><i class="fas fa-check-circle"></i></span>';
                } else {
                    $nl = '<span class="btn btn-danger btn-sm "><i class="fas fa-times-circle"></i></span>';
                }
                if ($type->is_pl) {
                    $pl = '<span class="btn btn-success btn-sm "><i class="fas fa-check-circle"></i></span>';
                } else {
                    $pl = '<span class="btn btn-danger btn-sm "><i class="fas fa-times-circle"></i></span>';
                }
                if ($type->is_us) {
                    $us = '<span class="btn btn-success btn-sm "><i class="fas fa-check-circle"></i></span>';
                } else {
                    $us = '<span class="btn btn-danger btn-sm "><i class="fas fa-times-circle"></i></span>';
                }
                if ($type->is_ca) {
                    $ca = '<span class="btn btn-success btn-sm "><i class="fas fa-check-circle"></i></span>';
                } else {
                    $ca = '<span class="btn btn-danger btn-sm "><i class="fas fa-times-circle"></i></span>';
                }

                $nestedData['id'] = $type->id;
                $nestedData['name'] = $type->name;
                $nestedData['uk'] = $uk;
                $nestedData['de'] = $de;
                $nestedData['fr'] = $fr;
                $nestedData['it'] = $it;
                $nestedData['es'] = $es;
                $nestedData['se'] = $se;
                $nestedData['nl'] = $nl;
                $nestedData['pl'] = $pl;
                $nestedData['us'] = $us;
                $nestedData['ca'] = $ca;

                $data[] = $nestedData;

            }
        }

        $json_data = array(
            "draw"            => intval($request->input('draw')),  
            "recordsTotal"    => intval($totalData),  
            "recordsFiltered" => intval($totalFiltered), 
            "data"            => $data   
        );

        return $json_data; 
        
    }

}