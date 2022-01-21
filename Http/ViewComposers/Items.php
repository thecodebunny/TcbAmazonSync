<?php

namespace Modules\TcbAmazonSync\Http\ViewComposers;

use App\Traits\Modules;
use Illuminate\View\View;
use Modules\TcbAmazonSync\Models\Warehouse;
use Modules\TcbAmazonSync\Models\Amazon\MwsApiSetting;
use Modules\TcbAmazonSync\Models\Amazon\Categories;

class Items
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
        $warehouses = Warehouse::all();
        $view->__set('mwsSettings', $mwsSettings);
        $view->__set('warehouses', $warehouses);

        $vendors = [];
        
        if ($view->getName() == 'common.items.edit') {

            $item = $view->getData()['item'];

            $com_item = $item;

            $amzItem = \Modules\TcbAmazonSync\Models\Amazon\Item::where('item_id', $item->id)->first();
            $sku = $amzItem->sku;

            $view->getFactory()->startPush('header_button_end', view('tcb-amazon-sync::partials.items.edit',  compact('item', 'mwsSettings', 'amzItem', 'sku')));

            $view->getFactory()->startPush('name_input_end', view('tcb-amazon-sync::partials.items.ean', compact('item', 'vendors', 'amzItem')));

        }

        $view->getFactory()->startPush('scripts', view('tcb-amazon-sync::amazon.script'));
    }
}