<?php

namespace Modules\TcbAmazonSync\Observers\Common;

use App\Models\Common\Item as ComItem;
use App\Abstracts\Observer;
use App\Traits\Jobs;
use App\Traits\Modules;
use Illuminate\Support\Facades\Storage;
use Modules\TcbAmazonSync\Jobs\CreateItem;
use Modules\TcbAmazonSync\Jobs\DeleteItem;
use Modules\TcbAmazonSync\Jobs\UpdateItem;
use Modules\TcbAmazonSync\Models\Amazon\Setting;
use Modules\TcbAmazonSync\Models\Amazon\Item as AmzItem;

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
        $settings = Setting::where('company_id', $item->company_id) ->first();
        if($settings->uk) {
            $amzItem = AmzItem::where('item_id', $item->id)->first();
            if (!$amzItem && empty($amzItem)) {
                $amzItem = new AmzItem;
            }
            $amzItem->country = 'Uk';
            $amzItem->company_id = $item->company_id;
            $amzItem->currency_code = 'GBP';
            $amzItem->item_id = $item->id;
            $amzItem->save();
        }
        if($settings->de) {
            $amzItem = AmzItem::where('item_id', $item->id)->first();
            if (!$amzItem && empty($amzItem)) {
                $amzItem = new AmzItem;
            }
            $amzItem->country = 'De';
            $amzItem->company_id = $item->company_id;
            $amzItem->currency_code = 'EUR';
            $amzItem->item_id = $item->id;
            $amzItem->save();
        }
        if($settings->fr) {
            $amzItem = AmzItem::where('item_id', $item->id)->first();
            if (!$amzItem && empty($amzItem)) {
                $amzItem = new AmzItem;
            }
            $amzItem->country = 'Fr';
            $amzItem->company_id = $item->company_id;
            $amzItem->item_id = $item->id;
            $amzItem->currency_code = 'EUR';
            $amzItem->save();
        }
        if($settings->it) {
            $amzItem = AmzItem::where('item_id', $item->id)->first();
            if (!$amzItem && empty($amzItem)) {
                $amzItem = new AmzItem;
            }
            $amzItem->country = 'It';
            $amzItem->company_id = $item->company_id;
            $amzItem->currency_code = 'EUR';
            $amzItem->item_id = $item->id;
            $amzItem->save();
        }
        if($settings->es) {
            $amzItem = AmzItem::where('item_id', $item->id)->first();
            if (!$amzItem && empty($amzItem)) {
                $amzItem = new AmzItem;
            }
            $amzItem->country = 'Es';
            $amzItem->company_id = $item->company_id;
            $amzItem->currency_code = 'EUR';
            $amzItem->item_id = $item->id;
            $amzItem->save();
        }
        if($settings->nl) {
            $amzItem = AmzItem::where('item_id', $item->id)->first();
            if (!$amzItem && empty($amzItem)) {
                $amzItem = new AmzItem;
            }
            $amzItem->country = 'Nl';
            $amzItem->company_id = $item->company_id;
            $amzItem->currency_code = 'EUR';
            $amzItem->item_id = $item->id;
            $amzItem->save();
        }
        if($settings->pl) {
            $amzItem = AmzItem::where('item_id', $item->id)->first();
            if (!$amzItem && empty($amzItem)) {
                $amzItem = new AmzItem;
            }
            $amzItem->country = 'Pl';
            $amzItem->company_id = $item->company_id;
            $amzItem->currency_code = 'EUR';
            $amzItem->item_id = $item->id;
            $amzItem->save();
        }
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
        $settings = Setting::where('company_id', $item->company_id) ->first();
        if($settings->uk) {
            $amzItem = AmzItem::where('item_id', $item->id)->first();
            if (!$amzItem && empty($amzItem)) {
                $amzItem = new AmzItem;
            }
            $amzItem->country = 'Uk';
            $amzItem->company_id = $item->company_id;
            $amzItem->currency_code = 'GBP';
            $amzItem->item_id = $item->id;
            $amzItem->save();
        }
        if($settings->de) {
            $amzItem = AmzItem::where('item_id', $item->id)->first();
            if (!$amzItem && empty($amzItem)) {
                $amzItem = new AmzItem;
            }
            $amzItem->country = 'De';
            $amzItem->company_id = $item->company_id;
            $amzItem->currency_code = 'EUR';
            $amzItem->item_id = $item->id;
            $amzItem->save();
        }
        if($settings->fr) {
            $amzItem = AmzItem::where('item_id', $item->id)->first();
            if (!$amzItem && empty($amzItem)) {
                $amzItem = new AmzItem;
            }
            $amzItem->country = 'Fr';
            $amzItem->company_id = $item->company_id;
            $amzItem->currency_code = 'EUR';
            $amzItem->item_id = $item->id;
            $amzItem->save();
        }
        if($settings->it) {
            $amzItem = AmzItem::where('item_id', $item->id)->first();
            if (!$amzItem && empty($amzItem)) {
                $amzItem = new AmzItem;
            }
            $amzItem->country = 'It';
            $amzItem->company_id = $item->company_id;
            $amzItem->currency_code = 'EUR';
            $amzItem->item_id = $item->id;
            $amzItem->save();
        }
        if($settings->es) {
            $amzItem = AmzItem::where('item_id', $item->id)->first();
            if (!$amzItem && empty($amzItem)) {
                $amzItem = new AmzItem;
            }
            $amzItem->country = 'Es';
            $amzItem->company_id = $item->company_id;
            $amzItem->currency_code = 'EUR';
            $amzItem->item_id = $item->id;
            $amzItem->save();
        }
        if($settings->nl) {
            $amzItem = AmzItem::where('item_id', $item->id)->first();
            if (!$amzItem && empty($amzItem)) {
                $amzItem = new AmzItem;
            }
            $amzItem->country = 'Nl';
            $amzItem->company_id = $item->company_id;
            $amzItem->currency_code = 'EUR';
            $amzItem->item_id = $item->id;
            $amzItem->save();
        }
        if($settings->pl) {
            $amzItem = AmzItem::where('item_id', $item->id)->first();
            if (!$amzItem && empty($amzItem)) {
                $amzItem = new AmzItem;
            }
            $amzItem->country = 'Pl';
            $amzItem->company_id = $item->company_id;
            $amzItem->currency_code = 'EUR';
            $amzItem->item_id = $item->id;
            $amzItem->save();
        }
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
            $dbItems = AmzItem::where('item_id', $item->id)->get();
            foreach($dbItems as $dbItem) {

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
