<?php

namespace Modules\TcbAmazonSync\Http\Controllers\Amazon;

use App\Abstracts\Http\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
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

}