<?php

namespace Modules\TcbAmazonSync\Http\Controllers\Amazon;

use App\Abstracts\Http\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Route;
use Modules\TcbAmazonSync\Models\Amazon\Warehouse as AmzWarehouse;

class Warehouse extends Controller
{

    public function __construct()
    {
        $this->middleware('admin');
    }
    

    public function index()
    {
        $warehouses =  AmzWarehouse::all();
        return view('tcb-amazon-sync::amazon.warehouses.index', compact('warehouses'));
    }

    public function create()
    {
        return view('tcb-amazon-sync::amazon.warehouses.create');
    }

    public function save(Request $request)
    {
        
        $warehouse = new AmzWarehouse;
        $warehouse->company_id = Route::current()->originalParameter('company_id');
        $warehouse->name = $request->name;
        $warehouse->enabled = $request->enabled;
        $warehouse->default_warehouse = $request->default_warehouse;
        $warehouse->street_1 = $request->street_1;
        $warehouse->street_2 = $request->street_2;
        $warehouse->postcode = $request->postcode;
        $warehouse->city = $request->city;
        $warehouse->country = $request->country;
        $warehouse->save();
        return $this->index();
    }

    public function edit($id)
    {
        $warehouse = AmzWarehouse::where('id', $id)->first();
        return view('tcb-amazon-sync::amazon.warehouses.edit', compact('warehouse'));
    }


    public function update(Request $request, $id)
    {
        $warehouse = AmzWarehouse::where('id', $id)->first();
        $warehouse->company_id = Route::current()->originalParameter('company_id');
        $warehouse->name = $request->name;
        if (!$request->enabled){ $request->enabled = 0; }
        $warehouse->enabled = $request->enabled;
        $warehouse->default_warehouse = $request->default_warehouse;
        $warehouse->street_1 = $request->street_1;
        $warehouse->street_2 = $request->street_2;
        $warehouse->postcode = $request->postcode;
        $warehouse->city = $request->city;
        $warehouse->country = $request->country;
        $warehouse->save();
        $warehouses = AmzWarehouse::all();
        return $this->index();
    }

    public function destroy($id)
    {
        $warehouse = AmzWarehouse::where('id', $id)->first();
        $warehouse->delete();
        $response = [
            'success'   => true,
            'message'   => 'Warehouse Successfully Deleted.'
        ];
        return $response;
    }
    
    public function duplicate($id)
    {
        $oldWarehouse = AmzWarehouse::where('id', $id)->first();
        $warehouse = new AmzWarehouse;
        $warehouse->company_id = Route::current()->originalParameter('company_id');
        $warehouse->name = $oldWarehouse->name;
        $warehouse->enabled = $oldWarehouse->enabled;
        $warehouse->default_warehouse = $oldWarehouse->default_warehouse;
        $warehouse->street_1 = $oldWarehouse->street_1;
        $warehouse->street_2 = $oldWarehouse->street_2;
        $warehouse->postcode = $oldWarehouse->postcode;
        $warehouse->city = $oldWarehouse->city;
        $warehouse->country = $oldWarehouse->country;
        $warehouse->save();
        return $this->edit($warehouse->id);
    }

}