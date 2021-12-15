<?php

namespace Modules\TcbAmazonSync\Observers\Inventory;

use App\Models\Common\Item as Model;
use App\Traits\Jobs;
use App\Traits\Modules;
use Modules\TcbAmazonSync\Jobs\CreateItem;
use Modules\TcbAmazonSync\Jobs\DeleteItem;
use Modules\TcbAmazonSync\Jobs\UpdateItem;
use Modules\Inventory\Models\Item as InvItem;
use Modules\TcbAmazonSync\Models\Amazon\UkItem;

class Item
{
    use Jobs, Modules;

    /**
     * Listen to the created event.
     *
     * @param  Model $item
     *
     * @return void
     */
    public function created(Model $item)
    {
        /*
        if (!$this->moduleIsEnabled('tcb-amazon-sync')) {
            return;
        }

        $request = request();

        $this->dispatch(new CreateItem($request, $item));
        */
    }

    public function saved(Model $item)
    {
        /*
        if (!$this->moduleIsEnabled('tcb-amazon-sync')) {
            return;
        }

        $dbInvtentory = InvItem::where('item_id', $item->id);

        $dbAsin = UkItem::where('com_item_id', $item->id)->first();
        if (!$dbAsin) {
            $dbAsin = new UkItem;
        }
        $dbAsin->com_item_id = $item->id;
        $dbAsin->item_id = $dbInvtentory->id;
        $dbAsin->save();
        */
    }

    /**
     * Listen to the created event.
     *
     * @param  Model $item
     *
     * @return void
     */
    public function updated(Model $item)
    {
        /*
        if (!$this->moduleIsEnabled('tcb-amazon-sync')) {
            return;
        }

        $request = request();
        $this->dispatch(new UpdateItem($request, $item));
        */
    }

    /**
     * Listen to the deleted event.
     *
     * @param  Model $item
     *
     * @return void
     */
    public function deleted(Model $item)
    {
        
        if (!$this->moduleIsEnabled('tcb-amazon-sync')) {
            return;
        }

        $dbAsin = UkItem::where('com_item_id', $item->id)->first();

        $this->dispatch(new DeleteItem($dbAsin));
    }
}
