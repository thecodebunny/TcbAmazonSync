<?php

namespace Modules\TcbAmazonSync\Observers\Common;

use App\Models\Common\Item as ComItem;
use App\Abstracts\Observer;
use App\Traits\Jobs;
use App\Traits\Modules;
use Modules\TcbAmazonSync\Jobs\CreateItem;
use Modules\TcbAmazonSync\Jobs\DeleteItem;
use Modules\TcbAmazonSync\Jobs\UpdateItem;
use Modules\TcbAmazonSync\Models\Amazon\UkItem;
use Modules\TcbAmazonSync\Models\Amazon\Asin as AmzAsin;

class Item extends Observer
{
    use Jobs, Modules;

    /**
     * Listen to the created event.
     *
     * @param  ComItem $item
     *
     * @return void
     */
    public function created(ComItem $item)
    {
        if (!$this->moduleIsEnabled('tcb-amazon-sync')) {
            return;
        }
        $request = request();
        $amzItem = AmzAsin::where('item_id', $item->item_id)->first();
        if (!$amzItem && empty($amzItem)) {
            $amzItem = new AmzAsin;
        }
        $amzItem->ean = $request->ean;
        $amzItem->item_id = $item->item_id;
        $amzItem->save();
    }

    public function saved(ComItem $item)
    {
        
    }

    /**
     * Listen to the updated event.
     *
     * @param  ComItem $item
     *
     * @return void
     */
    public function updated(ComItem $item)
    {
        if (!$this->moduleIsEnabled('tcb-amazon-sync')) {
            return;
        }
        $request = request();
        $amzItem = AmzAsin::where('item_id', $item->item_id)->first();
        if (!$amzItem && empty($amzItem)) {
            $amzItem = new AmzAsin;
        }
        $amzItem->ean = $request->ean;
        $amzItem->item_id = $item->item_id;
        $amzItem->save();
    }

    /**
     * Listen to the deleted event.
     *
     * @param  ComItem $item
     *
     * @return void
     */
    public function deleted(ComItem $item)
    {
        
        if (!$this->moduleIsEnabled('tcb-amazon-sync')) {
            return;
        }
            error_log('ITEM');
            $dbItem = UkItem::where('item_id', $item->item_id)->first();
            if ($dbItem && !empty($dbItem)) {

                if ($dbItem->main_picture) {
                    Storage::delete($dbItem->main_picture);
                }
                if ($dbItem->picture_1) {
                    Storage::delete($dbItem->picture_1);
                }
                if ($dbItem->picture_2) {
                    Storage::delete($dbItem->picture_2);
                }
                if ($dbItem->picture_3) {
                    Storage::delete($dbItem->picture_3);
                }
                if ($dbItem->picture_4) {
                    Storage::delete($dbItem->picture_4);
                }
                if ($dbItem->picture_5) {
                    Storage::delete($dbItem->picture_5);
                }
                if ($dbItem->picture_6) {
                    Storage::delete($dbItem->picture_6);
                }
                $dbItem->delete();

            }
    }
}
