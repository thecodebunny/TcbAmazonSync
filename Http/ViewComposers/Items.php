<?php

namespace Modules\TcbAmazonSync\Http\ViewComposers;

use App\Traits\Modules;
use Illuminate\View\View;
use Modules\Inventory\Models\Warehouse;
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
        $view->__set('mwsSettings', $mwsSettings);

        $vendors = [];
        
        $warehouses = Warehouse::enabled()->pluck('name', 'id');

        if ($view->getName() == 'inventory::items.edit') {

            $item = $view->getData()['item'];

            $com_item = $item;

            $inventory_item = $item->inventory()->first();

            //$amazon_item = $item->amazoninventory()->first();

            $amz_item = \Modules\TcbAmazonSync\Models\Amazon\Item::where('item_id', $item->id)->first();
            $uk_item = \Modules\TcbAmazonSync\Models\Amazon\UkItem::where('item_id', $inventory_item->id)->first();
            $sku = $inventory_item->sku;

            $view->__set('uk_item', $uk_item);

            $track_control = !empty($inventory_item) ? true : false;

            $view->getFactory()->startPush('header_button_end', view('tcb-amazon-sync::partials.items.edit',  compact('item', 'inventory_item', 'mwsSettings', 'uk_item', 'warehouses', 'amz_item', 'sku')));

            $view->getFactory()->startPush('sku_input_end', view('tcb-amazon-sync::partials.items.ean', compact('item', 'inventory_item', 'amz_item', 'vendors', 'warehouses', 'track_control')));

        }

        $view->getFactory()->startPush('scripts', view('tcb-amazon-sync::amazon.script'));
    }
}