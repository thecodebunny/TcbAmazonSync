<?php

namespace Modules\TcbAmazonSync\Jobs;

use App\Abstracts\Job;
use App\Interfaces\Job\ShouldDelete;
use Illuminate\Support\Facades\Storage;

class DeleteItem extends Job
{
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if ($item->main_picture) {
            Storage::delete($item->main_picture);
        }
        if ($item->picture_1) {
            Storage::delete($item->picture_1);
        }
        if ($item->picture_2) {
            Storage::delete($item->picture_2);
        }
        if ($item->picture_3) {
            Storage::delete($item->picture_3);
        }
        if ($item->picture_4) {
            Storage::delete($item->picture_4);
        }
        if ($item->picture_5) {
            Storage::delete($item->picture_5);
        }
        if ($item->picture_6) {
            Storage::delete($item->picture_6);
        }
        $item->delete();
    }
}
