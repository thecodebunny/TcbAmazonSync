<?php

namespace Modules\TcbAmazonSync\Http\Controllers\Amazon;

use DB;
use App\Abstracts\Http\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Route;
use App\Models\Common\Item as ComItem;
use Modules\TcbAmazonSync\Models\Amazon\Item as AmzItem;
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
        if($settings->uk) {
            $dbUkItem = AmzItem::where('item_id', $item_id)->where('country', 'Uk')->where('company_id', $this->company_id)->first();
            if (!$dbUkItem) {
                $amzItems['Uk']['item'] = $this->createAmzItem($item, 'Uk');
                $amzItems['Uk']['cat_name'] = '';
            } else {
                $amzItems['Uk']['item'] = $dbUkItem;
                $cat = Categories::where('uk_node_id', $dbUkItem->category_id)->first();
                if($cat) {
                    $amzItems['Uk']['cat_name'] = $cat->node_path;
                } else {
                    $amzItems['Uk']['cat_name'] = '';
                }
            }
        }
        if($settings->de) {
            $dbDeItem = AmzItem::where('item_id', $item_id)->where('country', 'De')->where('company_id', $this->company_id)->first();
            if (!$dbDeItem) {
                $amzItems['De']['item'] = $this->createAmzItem($item, 'De');
                $amzItems['De']['cat_name'] = '';
            } else {
                $amzItems['De']['item'] = $dbDeItem;
                $cat = Categories::where('uk_node_id', $dbDeItem->category_id)->first();
                if($cat) {
                    $amzItems['De']['cat_name'] = $cat->node_path;
                } else {
                    $amzItems['De']['cat_name'] = '';
                }
            }
        }
        if($settings->fr) {
            $dbFrItem = AmzItem::where('item_id', $item_id)->where('country', 'Fr')->where('company_id', $this->company_id)->first();
            if (!$dbFrItem) {
                $amzItems['Fr']['item'] = $this->createAmzItem($item, 'Fr');
                $amzItems['Fr']['cat_name'] = '';
            } else {
                $amzItems['Fr']['item'] = $dbFrItem;
                $cat = Categories::where('uk_node_id', $dbFrItem->category_id)->first();
                if($cat) {
                    $amzItems['Fr']['cat_name'] = $cat->node_path;
                } else {
                    $amzItems['Fr']['cat_name'] = '';
                }
            }
        }
        if($settings->it) {
            $dbItItem = AmzItem::where('item_id', $item_id)->where('country', 'It')->where('company_id', $this->company_id)->first();
            if (!$dbItItem) {
                $amzItems['It']['item'] = $this->createAmzItem($item, 'It');
                $amzItems['It']['cat_name'] = '';
            } else {
                $amzItems['It']['item'] = $dbItItem;
                $cat = Categories::where('uk_node_id', $dbItItem->category_id)->first();
                if($cat) {
                    $amzItems['It']['cat_name'] = $cat->node_path;
                } else {
                    $amzItems['It']['cat_name'] = '';
                }
            }
        }
        if($settings->es) {
            $dbEsItem = AmzItem::where('item_id', $item_id)->where('country', 'Es')->where('company_id', $this->company_id)->first();
            if (!$dbEsItem) {
                $amzItems['Es']['item'] = $this->createAmzItem($item, 'Es');
                $amzItems['Es']['cat_name'] = '';
            } else {
                $amzItems['Es']['item'] = $dbEsItem;
                $cat = Categories::where('uk_node_id', $dbEsItem->category_id)->first();
                if($cat) {
                    $amzItems['Es']['cat_name'] = $cat->node_path;
                } else {
                    $amzItems['Es']['cat_name'] = '';
                }
            }
        }
        if($settings->se) {
            $dbSeItem = AmzItem::where('item_id', $item_id)->where('country', 'Se')->where('company_id', $this->company_id)->first();
            if (!$dbSeItem) {
                $amzItems['Se']['item'] = $this->createAmzItem($item, 'Se');
                $amzItems['Se']['cat_name'] = '';
            } else {
                $amzItems['Se']['item'] = $dbSeItem;
                $cat = Categories::where('uk_node_id', $dbSeItem->category_id)->first();
                if($cat) {
                    $amzItems['Se']['cat_name'] = $cat->node_path;
                } else {
                    $amzItems['Se']['cat_name'] = '';
                }
            }
        }
        if($settings->nl) {
            $dbNlItem = AmzItem::where('item_id', $item_id)->where('country', 'Nl')->where('company_id', $this->company_id)->first();
            if (!$dbNlItem) {
                $amzItems['Nl']['item'] = $this->createAmzItem($item, 'Nl');
                $amzItems['Nl']['cat_name'] = '';
            } else {
                $amzItems['Nl']['item'] = $dbNlItem;
                $cat = Categories::where('uk_node_id', $dbNlItem->category_id)->first();
                if($cat) {
                    $amzItems['Nl']['cat_name'] = $cat->node_path;
                } else {
                    $amzItems['Nl']['cat_name'] = '';
                }
            }
        }
        if($settings->pl) {
            $dbPlItem = AmzItem::where('item_id', $item_id)->where('country', 'Pl')->where('company_id', $this->company_id)->first();
            if (!$dbPlItem) {
                $amzItems['Pl']['item'] = $this->createAmzItem($item, 'Pl');
                $amzItems['Pl']['cat_name'] = '';
            } else {
                $amzItems['Pl']['item'] = $dbPlItem;
                $cat = Categories::where('uk_node_id', $dbPlItem->category_id)->first();
                if($cat) {
                    $amzItems['Pl']['cat_name'] = $cat->node_path;
                } else {
                    $amzItems['Pl']['cat_name'] = '';
                }
            }
        }
        if($settings->us) {
            $dbUsItem = AmzItem::where('item_id', $item_id)->where('country', 'Us')->where('company_id', $this->company_id)->first();
            if (!$dbUsItem) {
                $amzItems['Us']['item'] = $this->createAmzItem($item, 'Us');
                $amzItems['Us']['cat_name'] = '';
            } else {
                $amzItems['Us']['item'] = $dbUsItem;
                $cat = Categories::where('uk_node_id', $dbUsItem->category_id)->first();
                if($cat) {
                    $amzItems['Us']['cat_name'] = $cat->node_path;
                } else {
                    $amzItems['Us']['cat_name'] = '';
                }
            }
        }

        return $this->response(
            'tcb-amazon-sync::amazon.asins.edit', 
            compact(
                'item', 
                'amzItems',
                'settings', 
                'brands', 
                'warehouses',
                'pTypes',
                'currencies'
            )
        );
    }

    public function createAmazonItem($item, $country)
    {
        $brand = Brand::where('default_brand', 1)->first();
        $warehouse = Warehouse::where('default_warehouse', 1)->first();
        $dbItem = new AmzItem;
        $dbItem->item_id = $item->id;
        $dbItem->brand = $brand->id;
        $dbItem->country = $country;
        $dbItem->company_id = $this->company_id;
        $dbItem->warehouse = $warehouse->id;
        $dbItem->quantity = $item->quantity;
        $dbItem->title = $item->name;
        $dbItem->description = $item->description;
        $dbItem->save();
        return $dbItem;
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