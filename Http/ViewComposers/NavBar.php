<?php

namespace Modules\TcbAmazonSync\Http\ViewComposers;

use App\Traits\Modules;
use Illuminate\View\View;
use Modules\TcbAmazonSync\Models\Amazon\Warehouse;
use Modules\TcbAmazonSync\Models\Amazon\MwsApiSetting;
use Modules\TcbAmazonSync\Models\Amazon\Categories;
use Modules\TcbAmazonSync\Models\Amazon\Order;

class NavBar
{
    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return mixed
     */
    public function compose(View $view)
    {
        $unshippedOrders = Order::where('order_status', '<>', 'Shipped')->get();
        if (! $unshippedOrders || empty($unshippedOrders)) {
            $unshippedOrders = ['NONE'];
        }
        $view->getFactory()->startPush('navbar_notifications', view('tcb-amazon-sync::layouts.navbar', compact('unshippedOrders')));
    }
}