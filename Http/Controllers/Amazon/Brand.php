<?php

namespace Modules\TcbAmazonSync\Http\Controllers\Amazon;

use App\Abstracts\Http\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Route;
use Modules\TcbAmazonSync\Models\Amazon\Item as AmzItem;
use Modules\TcbAmazonSync\Models\Amazon\Brand as AmzBrand;

class Brand extends Controller
{

    public function __construct()
    {
        $this->middleware('admin');
    }
    

    public function index()
    {
        $brands =  AmzBrand::all();
        return view('tcb-amazon-sync::amazon.brands.index', compact('brands'));
    }

    public function create()
    {
        return view('tcb-amazon-sync::amazon.brands.create');
    }

    public function save(Request $request)
    {
        
        $brand = new AmzBrand;
        $brand->company_id = Route::current()->originalParameter('company_id');
        $brand->name = $request->name;
        $brand->enabled = $request->enabled;
        if (!$request->default_brand){ $request->default_brand = 0; }
        $brand->default_brand = $request->default_brand;
        $brand->save();
        return $this->index();
    }

    public function edit($id)
    {
        $brand = AmzBrand::where('id', $id)->first();
        return view('tcb-amazon-sync::amazon.brands.edit', compact('brand'));
    }


    public function update(Request $request, $id)
    {
        $brand = AmzBrand::where('id', $id)->first();
        $brand->company_id = Route::current()->originalParameter('company_id');
        $brand->name = $request->name;
        $brand->enabled = $request->enabled;
        if (!$request->default_brand){ $request->default_brand = 0; }
        $brand->default_brand = $request->default_brand;
        $brand->save();
        
        $allProducts = AmzItem::where('brand',$brand->name)->get();
        foreach($allProducts as $product) {
            $product->brand = $request->name;
            $product->save();
        }
        $response = [
            'success'   => true,
            'message'   => 'Brand Successfully Updated.'
        ];
        return $response;
    }

    public function destroy($id)
    {
        $brand = AmzBrand::where('id', $id)->first();
        $brand->delete();
        $response = [
            'success'   => true,
            'message'   => 'Brand Successfully Deleted.'
        ];
        return $response;
    }
    
    public function duplicate($id)
    {
        $oldBrand = AmzBrand::where('id', $id)->first();
        $brand = new AmzBrand;
        $brand->company_id = Route::current()->originalParameter('company_id');
        $brand->name = $oldBrand->name;
        $brand->enabled = $oldBrand->enabled;
        $brand->default_brand = $oldBrand->default_brand;
        $brand->save();
        return $this->edit($brand->id);
    }

}