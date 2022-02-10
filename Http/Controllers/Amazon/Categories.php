<?php

namespace Modules\TcbAmazonSync\Http\Controllers\Amazon;

use DB;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Abstracts\Http\Controller;
use DataTables;
use Modules\TcbAmazonSync\Models\Amazon\Categories as AmzCategories;

class Categories extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function list()
    {
        $categories = AmzCategories::paginate(50);
        return $this->response('tcb-amazon-sync::categories.list', compact('categories'));
    }

    public function datatable(Request $request)
    {

        /**
        $data = AmzCategories::latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $actionBtn = '<a href="javascript:void(0)" class="edit btn btn-success btn-sm">Edit</a> <a href="javascript:void(0)" class="delete btn btn-danger btn-sm">Delete</a>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        */
        $columns = array( 
            0 => 'id',
            3 => 'node_path',
            1 => 'root_node',
            2 => 'uk_node_id',
            4 => 'fr_node_id',
            5 => 'it_node_id',
            6 => 'es_node_id',
            7 => 'de_node_id'
        );

        $categories = DB::table('amazon_categories');

        $totalData = $categories->count();

        $totalFiltered = $totalData; 

        $orderColumn = $request->input( 'order.0.column' );
        $orderDirection = $request->input( 'order.0.dir' );
        $length = $request->input( 'length' );
        $start = $request->input( 'start' );

        if ($request->has( 'search' )) {
            if ($request->input( 'search.value' ) != '') {
                $searchTerm = $request->input( 'search.value' );
                
                $categories->where( 'amazon_categories.node_path', 'Like', '%' . $searchTerm . '%' )
                        ->orWhere('amazon_categories.root_node', 'LIKE',"%{$searchTerm}%")
                        ->orWhere('amazon_categories.uk_node_id', 'LIKE',"%{$searchTerm}%")
                        ->orWhere('amazon_categories.fr_node_id', 'LIKE',"%{$searchTerm}%")
                        ->orWhere('amazon_categories.it_node_id', 'LIKE',"%{$searchTerm}%")
                        ->orWhere('amazon_categories.es_node_id', 'LIKE',"%{$searchTerm}%")
                        ->orWhere('amazon_categories.de_node_id', 'LIKE',"%{$searchTerm}%");
            }
        }
        
        if ($request->has( 'order' )) {
            if ($request->input( 'order.0.column' ) != '') {
                $categories->orderBy( $columns[intval( $orderColumn )], $orderDirection );
            }
        }

        $totalFiltered = $categories->count();

        config()->set('database.connections.mysql.strict', false);
        $categories = $categories->get();
        $categories = $categories->skip($start)->take($length);

        $data = array();

        if(!empty($categories))
        {
            foreach ($categories as $category)
            {

                $nestedData['id'] = $category->id;
                $nestedData['node_path'] = $category->node_path;
                $nestedData['root_node'] = $category->root_node;
                $nestedData['uk_node_id'] = $category->uk_node_id;
                $nestedData['fr_node_id'] = $category->fr_node_id;
                $nestedData['it_node_id'] = $category->it_node_id;
                $nestedData['es_node_id'] = $category->es_node_id;
                $nestedData['de_node_id'] = $category->de_node_id;

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