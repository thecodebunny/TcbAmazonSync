<?php

namespace Modules\TcbAmazonSync\Jobs;

use App\Abstracts\Job;
use App\Interfaces\Job\HasOwner;
use App\Interfaces\Job\HasSource;
use App\Interfaces\Job\ShouldCreate;
use App\Models\Common\Item;
use App\Jobs\Common\CreateItem as CoreCreateItem;
use Modules\TcbAmazonSync\Models\Amazon\UkItem as AmazonItem;

class CreateItem extends Job implements HasOwner, HasSource, ShouldCreate
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
    }
}