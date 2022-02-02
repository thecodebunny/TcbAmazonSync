<?php

namespace Modules\TcbAmazonSync\Http\Controllers\Amazon;

use App\Abstracts\Http\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Route;
use App\Models\Common\Item as ComItem;
use App\Models\Banking\Transaction;

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
        $items = AmzItem::where('company_id',$this->company_id)->where('country', $this->country)->paginate(50);
        return view('tcb-amazon-sync::amazon.items.index', compact('items'));
    }

    public function create()
    {
        $item = AmzItem::where('id',$id)->first();
        return $this->response('tcb-amazon-sync::items.create', compact('warehouses'));
    }

    public function createItem()
    {
        
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
        $amzItem = AmzItem::where('item_id', $request->get('item_id'))->where('id', $request->get('id'))->first();
        $picFolder = 'items/'. strtolower($amzItem->country) .'/'. $amzItem->asin;

        $amzItem->item_id = $request->get('item_id');
        $amzItem->enable = $request->get('enable');
        $amzItem->ean = $request->get('ean');
        $amzItem->asin = $request->get('asin');
        $amzItem->packaging = $request->get('packaging');
        $amzItem->sku = $request->get('sku');
        $amzItem->sale_price = $request->get('sale_price');
        $amzItem->price = $request->get('price');
        $amzItem->quantity = $request->get('quantity');
        $amzItem->title = $request->get('title');
        $amzItem->warehouse = $request->get('warehouse');
        $amzItem->bullet_point_1 = $request->get('bullet_point_1');
        $amzItem->bullet_point_2 = $request->get('bullet_point_2');
        $amzItem->bullet_point_3 = $request->get('bullet_point_3');
        $amzItem->bullet_point_4 = $request->get('bullet_point_4');
        $amzItem->bullet_point_5 = $request->get('bullet_point_5');
        $amzItem->bullet_point_6 = $request->get('bullet_point_6');
        $amzItem->description = $request->get('description');

        // Upload Main Image
        if ($request->file('main_picture')) {
            $mainPic = $request->file('main_picture');
            $fileName   = $mainPic->getClientOriginalName();
            $newPath = $picFolder .'/' .$fileName;
            $path = $request->file('main_picture')->storeAs(
                $picFolder, $fileName, 'local'
            );
            if ($amzItem->main_picture && $amzItem->main_picture !== $newPath) {
                Storage::delete($amzItem->main_picture);
            }
            $amzItem->main_picture = $path;
        }

        // Upload Other Images
        if ($request->file('picture_1')) {
            $pic1 = $request->file('picture_1');
            $fileName   = '1-' . $amzItem->uk_asin;
            $pic1Path = $picFolder .'/' .$fileName;
            $path1 = $request->file('picture_1')->storeAs(
                $picFolder, $fileName, 'public'
            );
            if ($amzItem->picture_1 && $amzItem->picture_1 !== $pic1Path) {
                Storage::delete($amzItem->picture_1);
            }
            $amzItem->picture_1 = $path1;
        }

        if ($request->file('picture_2')) {
            $pic2 = $request->file('picture_2');
            $fileName   = '2-' . $amzItem->uk_asin;
            $pic2Path = $picFolder .'/mainImage/' .$fileName;
            $path2 = $request->file('picture_2')->storeAs(
                $picFolder, $fileName, 'public'
            );
            if ($amzItem->picture_2 && $amzItem->picture_2 !== $pic2Path) {
                Storage::delete($amzItem->picture_2);
            }
            $amzItem->picture_2 = $path2;
        }

        if ($request->file('picture_3')) {
            $pic3 = $request->file('picture_3');
            $fileName   = '3-' . $amzItem->uk_asin;
            $pic3Path = $picFolder .'/variants/' .$fileName;
            $path3 = $request->file('picture_3')->storeAs(
                $picFolder, $fileName, 'public'
            );
            if ($amzItem->picture_3 && $amzItem->picture_3 !== $pic3Path) {
                Storage::delete($amzItem->picture_3);
            }
            $amzItem->picture_3 = $path3;
        }

        if ($request->file('picture_4')) {
            $pic4 = $request->file('picture_4');
            $fileName   = '4-' . $amzItem->uk_asin;
            $pic4Path = $picFolder .'/variants/' .$fileName;
            $path4 = $request->file('picture_4')->storeAs(
                $picFolder, $fileName, 'public'
            );
            if ($amzItem->picture_4 && $amzItem->picture_4 !== $pic4Path) {
                Storage::delete($amzItem->picture_4);
            }
            $amzItem->picture_4 = $path4;
        }

        if ($request->file('picture_5')) {
            $pic5 = $request->file('picture_5');
            $fileName   = '5-' . $amzItem->uk_asin;
            $pic5Path = $picFolder .'/' .$fileName;
            $path5 = $request->file('picture_5')->storeAs(
                $picFolder, $fileName, 'public'
            );
            if ($amzItem->picture_5 && $amzItem->picture_5 !== $pic5Path) {
                Storage::delete($amzItem->picture_5);
            }
            $amzItem->picture_5 = $path5;
        }

        if ($request->file('picture_6')) {
            $pic6 = $request->file('picture_6');
            $fileName   = '6-' . $amzItem->uk_asin;
            $pic6Path = $picFolder .'/' .$fileName;
            $path6 = $request->file('picture_6')->storeAs(
                $picFolder, $fileName, 'public'
            );
            if ($amzItem->picture_6 && $amzItem->picture_6 !== $pic6Path) {
                Storage::delete($amzItem->picture_6);
            }
            $amzItem->picture_6 = $path6;
        }

        $amzItem->save();

        $response = [
            'success' => true,
            'error' => false,
            'redirect' => route('items.index'),
            'data' => [],
        ];

        if ($response['success']) {

            $message = trans('messages.success.updated', ['type' => trans_choice('general.settings', 2)]);

            flash($message)->success();
        } else {
            $message = $response['message'];

            flash($message)->error()->important();
        }
        // return $this->response('tcb-amazon-sync::amazon.formoutput', compact('file'));
        // return $request; 
        response()->json($response);

    }

}