<?php

namespace Modules\TcbAmazonSync\Http\Controllers\Amazon;

use DB;
use Log;
use App\Abstracts\Http\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Banking\Transaction;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Config;
use App\Models\Common\Item as ComItem;
use Illuminate\Support\Facades\Storage;

//TCB Amazon Sync
use Modules\TcbAmazonSync\Models\Amazon\Item as AmzItem;
use Modules\TcbAmazonSync\Models\Amazon\Feed;
use Modules\TcbAmazonSync\Models\Amazon\Order;
use Modules\TcbAmazonSync\Models\Amazon\Issue;
use Modules\TcbAmazonSync\Models\Amazon\Setting;
use Modules\TcbAmazonSync\Models\Amazon\Categories;
use Modules\TcbAmazonSync\Models\Amazon\SpApiSetting;
use Modules\TcbAmazonSync\Models\Amazon\Warehouse;
use Modules\TcbAmazonSync\Http\Controllers\Amazon\Xml;

//Amazon SP API
use Modules\TcbAmazonSync\Http\Controllers\Amazon\SpApi;
use Thecodebunny\SpApi\Endpoint;
use Thecodebunny\SpApi\FeedType;
use Thecodebunny\SpApi\Document;
use Thecodebunny\SpApi\Api\FeedsApi;
use Thecodebunny\SpApi\Configuration;
use Thecodebunny\SpApi\Api\OrdersApi;
use Thecodebunny\SpApi\Api\CatalogApi;
use Thecodebunny\SpApi\Api\ListingsApi;
use Thecodebunny\SpApi\Api\AplusContentApi;
use Thecodebunny\SpApi\Api\ProductTypeDefinitionsApi;
use Thecodebunny\SpApi\Model\Feeds;
use Thecodebunny\SpApi\Model\Feeds\CreateFeedSpecification;
use Thecodebunny\SpApi\Model\Listings\ListingsItemPatchRequest;
use Thecodebunny\SpApi\Model\Listings\PatchOperation;

class Items extends Controller
{
    private $request;
    private $config;
    private $company_id;
    private $country;
    private $spApi;

    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->country = Route::current()->originalParameter('country');
        $this->company_id = Route::current()->originalParameter('company_id');
        $this->spApi = new SpApi($request);
    }
    
    public function index()
    {
        $items = AmzItem::where('company_id',$this->company_id)->paginate(50);
        $count = count($items);
        $country = $this->country;
        return view('tcb-amazon-sync::amazon.items.index', compact('count', 'country'));
    }

    public function create()
    {
        $item = AmzItem::where('id',$id)->first();
        return $this->response('tcb-amazon-sync::items.create', compact('warehouses'));
    }

    public function createItem()
    {
        
    }

    public function datatable(Request $request)
    {
        $columns = array( 
            0 => 'id',
            1 => 'title',
            2 => 'sku',
            3 => 'asin',
            4 => 'warnings',
            5 => 'category',
            6 => 'quantity',
            7 => 'price',
            8 => 'action',
        );

        $items = DB::table('amazon_items')->where('deleted_at', NULL)->select('*');

        $totalData = $items->count();

        $totalFiltered = $totalData; 

        $orderColumn = $request->input( 'order.0.column' );
        $orderDirection = $request->input( 'order.0.dir' );
        $length = $request->input( 'length' );
        $start = $request->input( 'start' );

        if ($request->has( 'search' )) {
            if ($request->input( 'search.value' ) != '') {
                $searchTerm = $request->input( 'search.value' );
                
                $items->Where( 'amazon_items.title', 'Like', '%' . $searchTerm . '%' )
                        ->orWhere('amazon_items.keywords', 'LIKE',"%{$searchTerm}%")
                        ->orWhere('amazon_items.sku', 'LIKE',"%{$searchTerm}%")
                        ->orWhere('amazon_items.brand', 'LIKE',"%{$searchTerm}%")
                        ->orWhere('amazon_items.asin', 'LIKE',"%{$searchTerm}%")
                        ->orWhere('amazon_items.ean', 'LIKE',"%{$searchTerm}%")
                        ->orWhere('amazon_items.description', 'LIKE',"%{$searchTerm}%")
                        ->orWhere('amazon_items.category_id', 'LIKE',"%{$searchTerm}%")
                        ->orWhere('amazon_items.bullet_point_1', 'LIKE',"%{$searchTerm}%")
                        ->orWhere('amazon_items.bullet_point_2', 'LIKE',"%{$searchTerm}%")
                        ->orWhere('amazon_items.bullet_point_3', 'LIKE',"%{$searchTerm}%")
                        ->orWhere('amazon_items.bullet_point_4', 'LIKE',"%{$searchTerm}%")
                        ->orWhere('amazon_items.bullet_point_5', 'LIKE',"%{$searchTerm}%")
                        ->orWhere('amazon_items.bullet_point_6', 'LIKE',"%{$searchTerm}%");
            }
        }
        
        if ($request->has( 'order' )) {
            if ($request->input( 'order.0.column' ) != '' && $request->input( 'order.0.column' ) != 4) {
                $items->orderBy( $columns[intval( $orderColumn )], $orderDirection );
            }
        }

        $totalFiltered = $items->count();

        config()->set('database.connections.mysql.strict', false);
        $items = $items->where('deleted_at', NULL)->orWhere('deleted_at', '')->get();
        $items = $items->skip($start)->take($length);

        $data = array();

        if(!empty($items))
        {
            foreach ($items as $item)
            {
                if($item->deleted_at == NULL || empty($item->deleted_at)) {
                if ($item->main_picture) {
                    $mainPic = '<img src="'. $item->main_picture . '" class="avatar image-style p-1 mr-3 item-img hidden-md col-aka tcb-image" />';
                } else {
                    $mainPic = '<img src="'.asset('/public/tcb-amazon-sync/img/no-image.png').'" class="avatar image-style p-1 mr-3 item-img hidden-md col-aka tcb-image" />';
                }

                if ($item->otherseller_warning) {
                    $warning = '<span style="color: #FFF !important" class="btn btn-danger btn-sm text-white" data-toggle="tooltip" data-placement="top" title=" '.trans('tcb-amazon-sync::items.warnings.otherseller') .'"><i class="fas fa-store"></i></span>';
                } else {
                    $warning = '';
                }

                if (! $item->keywords) {
                    $keywords = '<span style="color: #FFF !important" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="'. trans('tcb-amazon-sync::items.warnings.keywords') .'"><i class="fas fa-key"></i></span>';
                } else {
                    $keywords = '';
                }

                if (strlen($item->title) < 150) {
                    $title = '<span style="color: #FFF !important" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="'. trans('tcb-amazon-sync::items.warnings.shorttitle') .'"><i class="fas fa-heading"></i></span>';
                } else {
                    $title = '';
                }

                if (! $item->bullet_point_5) {
                    $point = '<span style="color: #FFF !important" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="'. trans('tcb-amazon-sync::items.warnings.bulletpoints') .'"><i class="fas fa-list-ul"></i></span>';
                } else {
                    $point = '';
                }

                if (! $item->picture_6) {
                    $pic = '<span style="color: #FFF !important" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="'. trans('tcb-amazon-sync::items.warnings.images') .'"><i class="fas fa-images"></i></span>';
                } else {
                    $pic = '';
                }

                if (! $item->description) {
                    $desc = '<span style="color: #FFF !important" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="'. trans('tcb-amazon-sync::items.warnings.description') .'"><i class="fas fa-audio-description"></i></span>';
                } else {
                    $desc = '';
                }

                $allWarnings = $warning . $keywords . $title . $point . $pic . $desc;

                if ($request->country == 'Uk' && !$item->is_uploaded_uk) {
                    $uploadButton = '<a id="uploadAmazonItem" class="dropdown-item" data-url="'. route('tcb-amazon-sync.amazon.item.upload',  ['id' => $item->id, 'country' => 'Uk']) .'"><i class="fas fa-upload"></i>'. trans('tcb-amazon-sync::items.amazon.upload') .'</a>';
                } elseif ($request->country == 'Uk' && $item->is_uploaded_uk) {
                    $uploadButton = '<a id="updateAmazonItem" class="dropdown-item" data-url="'. route('tcb-amazon-sync.amazon.item.updateOnline',  ['id' => $item->id, 'country' => 'Uk']) .'"><i class="fas fa-upload"></i>'. trans('tcb-amazon-sync::items.amazon.updateonline') .'</a>';
                }

                $actions = '<div class="dropdown">
                        <a class="btn btn-neutral btn-sm text-light items-align-center p-2" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-ellipsis-h text-muted"></i>
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink2">
                            <li>
                                <a class="dropdown-item" href="'. route('tcb-amazon-sync.items.show', ['id' => $item->id, 'country' => $request->country]) .'">
                                    <i class="fas fa-eye"></i> '. trans('general.show') .'
                                </a>
                            </li>
                            <div class="dropdown-divider"></div>
                            <li>
                                <a class="dropdown-item" href="'. route('tcb-amazon-sync.amazon.asinsetup', $item->item_id) .'">
                                    <i class="fas fa-edit"></i> '. trans('general.edit') .'
                                </a>
                            </li>
                            <div class="dropdown-divider"></div>
                            <li>
                                ' . $uploadButton . '
                            </li>
                        </ul>
                    </div>';
                
                $nestedData['id'] = $item->id;
                $nestedData['title'] = $mainPic . ' <a href="'. route('tcb-amazon-sync.items.show', ['id' => $item->id, 'country' => $request->country]) .'">' . substr($item->title,0,30).'...</a>';
                $nestedData['sku'] = $item->sku;
                $nestedData['asin'] = $item->asin;
                $nestedData['warnings'] = $allWarnings;
                $nestedData['category'] = $item->category_id;
                $nestedData['quantity'] = $item->quantity;
                $nestedData['price'] = $item->price;
                $nestedData['action'] = $actions;

                $data[] = $nestedData;
                }

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

    public function edit($id, $country)
    {
        
        $item = AmzItem::where('id',$id)->first();
        return view('tcb-amazon-sync::amazon.items.edit', compact('item'));
        
    }

    public function showItem($id, $country)
    {
        $item = AmzItem::where('id',$id)->first();
        $orders = Order::where('asin_ids', 'LIKE', '%'.$item->asin.'%')->paginate(10);
        $numberOrders = Order::where('asin_ids', 'LIKE', '%'.$item->asin.'%')->count();
        $ukCategories = Categories::get(['uk_node_id', 'node_path']);
        $issues = Issue::where('amz_item_id', $item->id)->get();
        $country = $this->country;
        return $this->response('tcb-amazon-sync::amazon.items.show', compact('numberOrders', 'item','orders','country', 'issues'));
        
    }

    public function updateItem(Request $request)
    {
        $settings = Setting::where('company_id', $this->company_id)->first();
        $amzItem = AmzItem::where('item_id', $request->get('item_id'))->where('id', $request->get('id'))->first();
        $picFolder = 'items/'. strtolower($amzItem->country) .'/'. $amzItem->asin;

        if(! $request->get('currency_code')) {
            
        }

        $amzItem->item_id = $request->get('item_id');
        $amzItem->enable = $request->get('enable');
        $amzItem->ean = $request->get('ean');
        $amzItem->asin = $request->get('asin');
        $amzItem->packaging = $request->get('packaging');
        $amzItem->product_type = $request->get('product_type');
        $amzItem->sku = $request->get('sku');
        $amzItem->brand = $request->get('brand');
        $amzItem->height = $request->get('height');
        $amzItem->length = $request->get('length');
        $amzItem->width = $request->get('width');
        $amzItem->weight = $request->get('weight');
        $amzItem->material = $request->get('material');
        $amzItem->country_of_origin = $request->get('country_of_origin');
        $amzItem->sale_price = $request->get('sale_price');
        $amzItem->sale_start_date = $request->get('sale_start_date');
        $amzItem->sale_end_date = $request->get('sale_end_date');
        $amzItem->currency_code = $request->get('currency_code');
        $amzItem->price = $request->get('price');
        $amzItem->category_id = $request->get('category_id');
        $amzItem->quantity = $request->get('quantity');
        $amzItem->title = $request->get('title');
        $amzItem->size = $request->get('size');
        $amzItem->color = $request->get('color');
        $amzItem->warehouse = $request->get('warehouse');
        $amzItem->bullet_point_1 = $request->get('bullet_point_1');
        $amzItem->bullet_point_2 = $request->get('bullet_point_2');
        $amzItem->bullet_point_3 = $request->get('bullet_point_3');
        $amzItem->bullet_point_4 = $request->get('bullet_point_4');
        $amzItem->bullet_point_5 = $request->get('bullet_point_5');
        $amzItem->bullet_point_6 = $request->get('bullet_point_6');
        $amzItem->description = $request->get('description');
        $amzItem->keywords = $request->get('keywords');
        $amzItem->weight_measure = $request->get('weight_measure');
        $amzItem->height_measure = $request->get('height_measure');
        $amzItem->width_measure = $request->get('width_measure');
        $amzItem->length_measure = $request->get('length_measure');
        $amzItem->lead_time_to_ship_max_days = $request->get('lead_time_to_ship_max_days');

        // Upload Main Image
        if ($request->file('main_picture')) {
            $mainPic = $request->file('main_picture');
            $fileName   = 'main-' . $mainPic->getClientOriginalName();
            $picFolder = $settings->folder . '/' . $amzItem->asin . '/' . $amzItem->country;
            Storage::disk('do')->delete(str_replace($settings->url,'',$amzItem->main_picture));
            Storage::disk('do')->put(
                $picFolder . '/' . $fileName, file_get_contents($request->file('main_picture'))
            );
            $amzItem->main_picture = $settings->url . '/'. $picFolder .'/'. $fileName;
        }

        // Upload Other Images
        if ($request->file('picture_1')) {
            $pic1 = $request->file('picture_1');
            $fileName   = '1-' . $amzItem->asin . '-' . $pic1->getClientOriginalName();
            $picFolder = $settings->folder . '/' . $amzItem->asin . '/' . $amzItem->country;
            Storage::disk('do')->delete(str_replace($settings->url,'',$amzItem->picture_1));
            Storage::disk('do')->put(
                $picFolder . '/' . $fileName, file_get_contents($request->file('picture_1'))
            );
            $amzItem->picture_1 = $settings->url . '/'. $picFolder .'/'. $fileName;
        }

        if ($request->file('picture_2')) {
            $pic2 = $request->file('picture_2');
            $fileName   = '2-' . $amzItem->asin . '-' . $pic2->getClientOriginalName();
            $picFolder = $settings->folder . '/' . $amzItem->asin . '/' . $amzItem->country;
            Storage::disk('do')->delete(str_replace($settings->url,'',$amzItem->picture_2));
            Storage::disk('do')->put(
                $picFolder . '/' . $fileName, file_get_contents($request->file('picture_2'))
            );
            $amzItem->picture_2 = $settings->url . '/'. $picFolder .'/'. $fileName;
        }

        if ($request->file('picture_3')) {
            $pic3 = $request->file('picture_3');
            $fileName   = '3-' . $amzItem->asin . '-' . $pic3->getClientOriginalName();
            $picFolder = $settings->folder . '/' . $amzItem->asin . '/' . $amzItem->country;
            Storage::disk('do')->delete(str_replace($settings->url,'',$amzItem->picture_3));
            Storage::disk('do')->put(
                $picFolder . '/' . $fileName, file_get_contents($request->file('picture_3'))
            );
            $amzItem->picture_3 = $settings->url . '/'. $picFolder .'/'. $fileName;
        }

        if ($request->file('picture_4')) {
            $pic4 = $request->file('picture_4');
            $fileName   = '4-' . $amzItem->asin . '-' . $pic4->getClientOriginalName();
            $picFolder = $settings->folder . '/' . $amzItem->asin . '/' . $amzItem->country;
            Storage::disk('do')->delete(str_replace($settings->url,'',$amzItem->picture_4));
            Storage::disk('do')->put(
                $picFolder . '/' . $fileName, file_get_contents($request->file('picture_4'))
            );
            $amzItem->picture_4 = $settings->url . '/'. $picFolder .'/'. $fileName;
        }

        if ($request->file('picture_5')) {
            $pic5 = $request->file('picture_5');
            $fileName   = '5-' . $amzItem->asin . '-' . $pic5->getClientOriginalName();
            $picFolder = $settings->folder . '/' . $amzItem->asin . '/' . $amzItem->country;
            Storage::disk('do')->delete(str_replace($settings->url,'',$amzItem->picture_5));
            Storage::disk('do')->put(
                $picFolder . '/' . $fileName, file_get_contents($request->file('picture_5'))
            );
            $amzItem->picture_5 = $settings->url . '/'. $picFolder .'/'. $fileName;
        }

        if ($request->file('picture_6')) {
            $pic6 = $request->file('picture_6');
            $fileName   = '6-' . $amzItem->asin . '-' . $pic6->getClientOriginalName();
            $picFolder = $settings->folder . '/' . $amzItem->asin . '/' . $amzItem->country;
            Storage::disk('do')->delete(str_replace($settings->url,'',$amzItem->picture_6));
            Storage::disk('do')->put(
                $picFolder . '/' . $fileName, file_get_contents($request->file('picture_6'))
            );
            $amzItem->picture_6 = $settings->url . '/'. $picFolder .'/'. $fileName;
        }

        $amzItem->save();

        $response = [
            'success' => true,
            'error' => false,
            'redirect' => route('items.index'),
            'data' => [],
        ];

        if ($response['success']) {

            $message = trans('messages.success.updated', ['type' => trans_choice('general.settings', 2)]) . config('filesystems.do.folder');

            flash($message)->success();
        } else {
            $message = $response['message'];

            flash($message)->error()->important();
        }
        response()->json($response);
        return config('tcb-amazon-sync::filesystems.do.endpoint') . '/'. config('tcb-amazon-sync::filesystems.do.folder');

    }

}