<?php

namespace Modules\TcbAmazonSync\Http\Controllers\Asin;

use App\Abstracts\Http\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\TcbAmazonSync\Models\Amazon\UkItem;
use Modules\TcbAmazonSync\Models\Amazon\Categories;
use Modules\TcbAmazonSync\Models\Amazon\MwsApiSetting;
use App\Traits\Jobs;
use Illuminate\Support\Facades\Storage;
//Amazon MWS API
use Thecodebunny\AmzMwsApi\AmazonOrderList;

class Items extends Controller
{
    use Jobs;

    public function create()
    {
        return $this->response('tcb-amazon-sync::items.create',);
    }

    public function createItem()
    {
        
    }

    public function edit()
    {
        
        $ukCategories = Categories::get(['uk_node_id', 'node_path']);
        return $this->response('tcb-amazon-sync::items.create', compact('ukCategories'));
        
    }

    public function updateItem(Request $request)
    {

        $amzItem = UkItem::where('item_id', $request->get('inv_item_id'))->first();

        if (! $amzItem) {
            $amzItem = new UkItem;
        }

        $amzItem->item_id = $request->get('inv_item_id');
        $amzItem->enable = $request->get('enable');
        $amzItem->ean = $request->get('ean');
        $amzItem->asin = $request->get('asin');
        $amzItem->sku = $request->get('sku');
        $amzItem->sale_price = $request->get('sale_price');
        $amzItem->price = $request->get('price');
        $amzItem->quantity = $request->get('quantity');
        $amzItem->title = $request->get('title');
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
            $newPath = 'items/'. $amzItem->item_id .'/' .$fileName;
            $path = $request->file('main_picture')->storeAs(
                'items/'. $amzItem->item_id, $fileName, 'local'
            );
            if ($amzItem->main_picture && $amzItem->main_picture !== $newPath) {
                Storage::delete($amzItem->main_picture);
            }
            $amzItem->main_picture = $path;
        }

        // Upload Other Images
        if ($request->file('picture_1')) {
            $pic1 = $request->file('picture_1');
            $fileName   = $pic1->getClientOriginalName();
            $pic1Path = 'items/'. $amzItem->item_id .'/' .$fileName;
            $path1 = $request->file('picture_1')->storeAs(
                'items/'. $amzItem->item_id, $fileName, 'public'
            );
            if ($amzItem->picture_1 && $amzItem->picture_1 !== $pic1Path) {
                Storage::delete($amzItem->picture_1);
            }
            $amzItem->picture_1 = $path1;
        }

        if ($request->file('picture_2')) {
            $pic2 = $request->file('picture_2');
            $fileName   = $pic2->getClientOriginalName();
            $pic2Path = 'items/'. $amzItem->item_id .'/' .$fileName;
            $path2 = $request->file('picture_2')->storeAs(
                'items/'. $amzItem->item_id, $fileName, 'public'
            );
            if ($amzItem->picture_2 && $amzItem->picture_2 !== $pic2Path) {
                Storage::delete($amzItem->picture_2);
            }
            $amzItem->picture_2 = $path2;
        }

        if ($request->file('picture_3')) {
            $pic3 = $request->file('picture_3');
            $fileName   = $pic3->getClientOriginalName();
            $pic3Path = 'items/'. $amzItem->item_id .'/' .$fileName;
            $path3 = $request->file('picture_3')->storeAs(
                'items/'. $amzItem->item_id, $fileName, 'public'
            );
            if ($amzItem->picture_3 && $amzItem->picture_3 !== $pic3Path) {
                Storage::delete($amzItem->picture_3);
            }
            $amzItem->picture_3 = $path3;
        }

        if ($request->file('picture_4')) {
            $pic4 = $request->file('picture_4');
            $fileName   = $pic4->getClientOriginalName();
            $pic4Path = 'items/'. $amzItem->item_id .'/' .$fileName;
            $path4 = $request->file('picture_4')->storeAs(
                'items/'. $amzItem->item_id, $fileName, 'public'
            );
            if ($amzItem->picture_4 && $amzItem->picture_4 !== $pic4Path) {
                Storage::delete($amzItem->picture_4);
            }
            $amzItem->picture_4 = $path4;
        }

        if ($request->file('picture_5')) {
            $pic5 = $request->file('picture_5');
            $fileName   = $pic5->getClientOriginalName();
            $pic5Path = 'items/'. $amzItem->item_id .'/' .$fileName;
            $path5 = $request->file('picture_5')->storeAs(
                'items/'. $amzItem->item_id, $fileName, 'public'
            );
            if ($amzItem->picture_5 && $amzItem->picture_5 !== $pic5Path) {
                Storage::delete($amzItem->picture_5);
            }
            $amzItem->picture_5 = $path5;
        }

        if ($request->file('picture_6')) {
            $pic6 = $request->file('picture_6');
            $fileName   = $pic6->getClientOriginalName();
            $pic6Path = 'items/'. $amzItem->item_id .'/' .$fileName;
            $path6 = $request->file('picture_6')->storeAs(
                'items/'. $amzItem->item_id, $fileName, 'public'
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
            'redirect' => route('inventory.items.index'),
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