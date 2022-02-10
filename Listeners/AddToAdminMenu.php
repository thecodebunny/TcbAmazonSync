<?php

namespace Modules\TcbAmazonSync\Listeners;

use App\Events\Menu\AdminCreated as Event;

class AddToAdminMenu
{
    /**
     * Handle the event.
     *
     * @param  Event $event
     * @return void
     */
    public function handle(Event $event)
    {

        // Add new menu item
        $event->menu->add([

            'title' => trans('tcb-amazon-sync::general.amzmenu'),
            'icon' => 'fab fa-amazon',
            'order' => 5,

        ]);

        $item = $event->menu->whereTitle(trans_choice('tcb-amazon-sync::general.amzmenu', 2));
        $item->route('tcb-amazon-sync.amazon.dashboard', trans('tcb-amazon-sync::general.amzdashboard'), [], 4, ['icon' => 'fas fa-tachometer-alt']);
        $item->route('tcb-amazon-sync.amazon.settings', trans('tcb-amazon-sync::general.amzsettings'), [], 4, ['icon' => 'fab fa-amazon']);
        $item->route('tcb-amazon-sync.amazon.warehouses', trans('tcb-amazon-sync::warehouse.warehouses'), [], 4, ['icon' => 'fas fa-warehouse']);
        $item->route('tcb-amazon-sync.amazon.brands', trans('tcb-amazon-sync::brand.brands'), [], 4, ['icon' => 'fas fa-copyright']);
        $item->route('tcb-amazon-sync.amazon.spapisettings', trans('tcb-amazon-sync::general.amzspsettings'), [], 4, ['icon' => 'fas fa-cog']);
        $item->route('tcb-amazon-sync.amazon.mwsapisettings', trans('tcb-amazon-sync::general.amzmwssettings'), [], 4, ['icon' => 'fas fa-cog']);
        $item->route('tcb-amazon-sync.amazon.categories', trans('tcb-amazon-sync::general.amzcategories'), [], 4, ['icon' => 'fas fa-list']);
        $item->route('tcb-amazon-sync.amazon.ptindex', trans('tcb-amazon-sync::general.pttypes'), [], 4, ['icon' => 'fas fa-cog']);
        
        // Add new menu item
        $event->menu->add([

            'title' => trans('tcb-amazon-sync::general.items'),
            'icon' => 'fab fa-amazon',
            'order' => 6,

        ]);
        $newItem = $event->menu->whereTitle(trans_choice('tcb-amazon-sync::general.items', 2));
        $newItem->route('tcb-amazon-sync.amazon.items.index', trans('tcb-amazon-sync::general.ukitems'), ['country' => 'Uk'], 4, ['icon' => 'fas fa-boxes']);
        
        // Add new menu item
        $event->menu->add([

            'title' => trans('tcb-amazon-sync::general.amzorders'),
            'icon' => 'fab fa-amazon',
            'order' => 6,

        ]);
        $salesItem = $event->menu->whereTitle(trans_choice('tcb-amazon-sync::general.amzorders', 2));
        $salesItem->route('tcb-amazon-sync.amazon.orders.index', trans('tcb-amazon-sync::general.amzorders'), [], 4, ['icon' => 'fas fa-file-invoice-dollar']);

    }
}