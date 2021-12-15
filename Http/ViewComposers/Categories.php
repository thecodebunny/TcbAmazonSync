<?php

namespace Modules\TcbAmazonSync\Http\ViewComposers;

use App\Traits\Modules;
use Illuminate\View\View;
use Modules\Inventory\Models\Warehouse;
use Modules\TcbAmazonSync\Models\Amazon\MwsApiSetting;
use Modules\TcbAmazonSync\Models\Amazon\Categories;

class Categories
{
    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return mixed
     */
    public function compose(View $view)
    {
        $mwsSettings = MwsApiSetting::first();
        
        $ukCategories = Categories::get(['uk_node_id', 'node_path']);
        $view->__set('mwsSettings', $mwsSettings);
        $view->__set('ukCategories', $ukCategories);

        if ($view->getName() == 'tcb-amazon-sync::items.edit') {
        }

        $view->getFactory()->startPush('scripts', view('tcb-amazon-sync::amazon.script'));
    }
}