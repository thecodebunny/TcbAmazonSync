<?php

namespace Modules\TcbAmazonSync\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Console\Scheduling\Schedule;

use App\Models\Common\Company;

//Module schedules
use Modules\TcbAmazonSync\Models\Amazon\Setting;

class ScheduleServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->app->booted(function () {
            $companies = Company::all();
            foreach ($companies as $company) {
                $schedule = $this->app->make(Schedule::class);
                $settings = Setting::where('company_id', $company->id)->first();
                if ($settings->uk && !empty($settings->uk)) {
                    if ($settings->items_update_on_amazon_cron) {
                        if ($settings->items_update_on_amazon_cron_frequency == 'Twice a Day') {
                            $schedule->command('amazon:update-items-amazon Uk')->everyFourHours()->withoutOverlapping()->sendOutputTo('/var/www/go/storage/logs/amz_items_amazon_cron.log');
                        }
                        if ($settings->items_update_on_amazon_cron_frequency == 'Once a Day') {
                            $schedule->command('amazon:update-items-amazon Uk')->dailyAt('01:01')->withoutOverlapping()->sendOutputTo('/var/www/go/storage/logs/amz_items_amazon_cron.log');
                        }
                        if ($settings->items_update_on_amazon_cron_frequency == 'Every 2 Days') {
                            $schedule->command('amazon:update-items-amazon Uk')->weekly()->days([1,3])->at('5:00')->withoutOverlapping()->sendOutputTo('/var/www/go/storage/logs/amz_items_amazon_cron.log');
                        }
                        if ($settings->items_update_on_amazon_cron_frequency == 'Every 3 Days') {
                            $schedule->command('amazon:update-items-amazon Uk')->weekly()->days([1,3,5,7])->at('01:01')->withoutOverlapping()->sendOutputTo('/var/www/go/storage/logs/amz_items_amazon_cron.log');
                        }
                        if ($settings->items_update_on_amazon_cron_frequency == 'Every Week') {
                            $schedule->command('amazon:update-items-amazon Uk')->weeklyOn(7, '01:01')->withoutOverlapping()->sendOutputTo('/var/www/go/storage/logs/amz_items_amazon_cron.log');
                        }
                    }
                    if ($settings->orders_download_cron) {
                        if ($settings->orders_download_cron_frequency == 'Twice a Day') {
                            $schedule->command('amazon:get-orders Uk')->everyFourHours()->withoutOverlapping()->sendOutputTo('/var/www/go/storage/logs/amz_orderscron.log');
                        }
                        if ($settings->orders_download_cron_frequency == 'Once a Day') {
                            $schedule->command('amazon:get-orders Uk')->dailyAt('00:01')->withoutOverlapping()->sendOutputTo('/var/www/go/storage/logs/amz_orderscron.log');
                        }
                        if ($settings->orders_download_cron_frequency == 'Every 2 Days') {
                            $schedule->command('amazon:get-orders Uk')->weekly()->days([1,3])->at('6:00')->withoutOverlapping()->sendOutputTo('/var/www/go/storage/logs/amz_orderscron.log');
                        }
                        if ($settings->orders_download_cron_frequency == 'Every 3 Days') {
                            $schedule->command('amazon:get-orders Uk')->weekly()->days([1,3,5,7])->at('00:01')->withoutOverlapping()->sendOutputTo('/var/www/go/storage/logs/amz_orderscron.log');
                        }
                        if ($settings->orders_download_cron_frequency == 'Every Week') {
                            $schedule->command('amazon:get-orders Uk')->weekly()->withoutOverlapping()->sendOutputTo('/var/www/go/storage/logs/amz_orderscron.log');
                        }
                    }
                    if ($settings->items_update_in_erp_cron) {
                        if ($settings->items_update_in_erp_cron_frequency == 'Twice a Day') {
                            $schedule->command('amazon:update-items-erp Uk')->everyFourHours()->withoutOverlapping()->sendOutputTo('/var/www/go/storage/logs/amz_items_erp_cron.log');
                        }
                        if ($settings->items_update_in_erp_cron_frequency == 'Once a Day') {
                            $schedule->command('amazon:update-items-erp Uk')->dailyAt('01:01')->withoutOverlapping()->sendOutputTo('/var/www/go/storage/logs/amz_items_erp_cron.log');
                        }
                        if ($settings->items_update_in_erp_cron_frequency == 'Every 2 Days') {
                            $schedule->command('amazon:update-items-erp Uk')->weekly()->days([1,3])->at('5:00')->withoutOverlapping()->sendOutputTo('/var/www/go/storage/logs/amz_items_erp_cron.log');
                        }
                        if ($settings->items_update_in_erp_cron_frequency == 'Every 3 Days') {
                            $schedule->command('amazon:update-items-erp Uk')->weekly()->days([1,3,5,7])->at('01:01')->withoutOverlapping()->sendOutputTo('/var/www/go/storage/logs/amz_items_erp_cron.log');
                        }
                        if ($settings->items_update_in_erp_cron_frequency == 'Every Week') {
                            $schedule->command('amazon:update-items-erp Uk')->weeklyOn(7, '01:01')->withoutOverlapping()->sendOutputTo('/var/www/go/storage/logs/amz_items_erp_cron.log');
                        }
                    }
                }
                if ($settings->de && !empty($settings->de)) {
                    if ($settings->items_update_on_amazon_cron) {
                        if ($settings->items_update_on_amazon_cron_frequency == 'Twice a Day') {
                            $schedule->command('amazon:update-items-amazon De')->everyFourHours()->withoutOverlapping()->sendOutputTo('/var/www/go/storage/logs/amz_items_amazon_cron.log');
                        }
                        if ($settings->items_update_on_amazon_cron_frequency == 'Once a Day') {
                            $schedule->command('amazon:update-items-amazon De')->dailyAt('01:01')->withoutOverlapping()->sendOutputTo('/var/www/go/storage/logs/amz_items_amazon_cron.log');
                        }
                        if ($settings->items_update_on_amazon_cron_frequency == 'Every 2 Days') {
                            $schedule->command('amazon:update-items-amazon De')->weekly()->days([1,3])->at('5:00')->withoutOverlapping()->sendOutputTo('/var/www/go/storage/logs/amz_items_amazon_cron.log');
                        }
                        if ($settings->items_update_on_amazon_cron_frequency == 'Every 3 Days') {
                            $schedule->command('amazon:update-items-amazon De')->weekly()->days([1,3,5,7])->at('01:01')->withoutOverlapping()->sendOutputTo('/var/www/go/storage/logs/amz_items_amazon_cron.log');
                        }
                        if ($settings->items_update_on_amazon_cron_frequency == 'Every Week') {
                            $schedule->command('amazon:update-items-amazon De')->weeklyOn(7, '01:01')->withoutOverlapping()->sendOutputTo('/var/www/go/storage/logs/amz_items_amazon_cron.log');
                        }
                    }
                    if ($settings->orders_download_cron) {
                        if ($settings->orders_download_cron_frequency == 'Twice a Day') {
                            $schedule->command('amazon:get-orders De')->everyFourHours()->withoutOverlapping()->sendOutputTo('/var/www/go/storage/logs/amz_orderscron.log');
                        }
                        if ($settings->orders_download_cron_frequency == 'Once a Day') {
                            $schedule->command('amazon:get-orders De')->dailyAt('00:01')->withoutOverlapping()->sendOutputTo('/var/www/go/storage/logs/amz_orderscron.log');
                        }
                        if ($settings->orders_download_cron_frequency == 'Every 2 Days') {
                            $schedule->command('amazon:get-orders De')->weekly()->days([1,3])->at('6:00')->withoutOverlapping()->sendOutputTo('/var/www/go/storage/logs/amz_orderscron.log');
                        }
                        if ($settings->orders_download_cron_frequency == 'Every 3 Days') {
                            $schedule->command('amazon:get-orders De')->weekly()->days([1,3,5,7])->at('00:01')->withoutOverlapping()->sendOutputTo('/var/www/go/storage/logs/amz_orderscron.log');
                        }
                        if ($settings->orders_download_cron_frequency == 'Every Week') {
                            $schedule->command('amazon:get-orders De')->weekly()->withoutOverlapping()->sendOutputTo('/var/www/go/storage/logs/amz_orderscron.log');
                        }
                    }
                    if ($settings->items_update_in_erp_cron) {
                        if ($settings->items_update_in_erp_cron_frequency == 'Twice a Day') {
                            $schedule->command('amazon:update-items-erp De')->everyFourHours()->withoutOverlapping()->sendOutputTo('/var/www/go/storage/logs/amz_items_erp_cron.log');
                        }
                        if ($settings->items_update_in_erp_cron_frequency == 'Once a Day') {
                            $schedule->command('amazon:update-items-erp De')->dailyAt('01:01')->withoutOverlapping()->sendOutputTo('/var/www/go/storage/logs/amz_items_erp_cron.log');
                        }
                        if ($settings->items_update_in_erp_cron_frequency == 'Every 2 Days') {
                            $schedule->command('amazon:update-items-erp De')->weekly()->days([1,3])->at('5:00')->withoutOverlapping()->sendOutputTo('/var/www/go/storage/logs/amz_items_erp_cron.log');
                        }
                        if ($settings->items_update_in_erp_cron_frequency == 'Every 3 Days') {
                            $schedule->command('amazon:update-items-erp De')->weekly()->days([1,3,5,7])->at('01:01')->withoutOverlapping()->sendOutputTo('/var/www/go/storage/logs/amz_items_erp_cron.log');
                        }
                        if ($settings->items_update_in_erp_cron_frequency == 'Every Week') {
                            $schedule->command('amazon:update-items-erp De')->weeklyOn(7, '01:01')->withoutOverlapping()->sendOutputTo('/var/www/go/storage/logs/amz_items_erp_cron.log');
                        }
                    }
                }
                if ($settings->fr && !empty($settings->fr)) {
                    if ($settings->items_update_on_amazon_cron) {
                        if ($settings->items_update_on_amazon_cron_frequency == 'Twice a Day') {
                            $schedule->command('amazon:update-items-amazon Fr')->everyFourHours()->withoutOverlapping()->sendOutputTo('/var/www/go/storage/logs/amz_items_amazon_cron.log');
                        }
                        if ($settings->items_update_on_amazon_cron_frequency == 'Once a Day') {
                            $schedule->command('amazon:update-items-amazon Fr')->dailyAt('01:01')->withoutOverlapping()->sendOutputTo('/var/www/go/storage/logs/amz_items_amazon_cron.log');
                        }
                        if ($settings->items_update_on_amazon_cron_frequency == 'Every 2 Days') {
                            $schedule->command('amazon:update-items-amazon Fr')->weekly()->days([1,3])->at('5:00')->withoutOverlapping()->sendOutputTo('/var/www/go/storage/logs/amz_items_amazon_cron.log');
                        }
                        if ($settings->items_update_on_amazon_cron_frequency == 'Every 3 Days') {
                            $schedule->command('amazon:update-items-amazon Fr')->weekly()->days([1,3,5,7])->at('01:01')->withoutOverlapping()->sendOutputTo('/var/www/go/storage/logs/amz_items_amazon_cron.log');
                        }
                        if ($settings->items_update_on_amazon_cron_frequency == 'Every Week') {
                            $schedule->command('amazon:update-items-amazon Fr')->weeklyOn(7, '01:01')->withoutOverlapping()->sendOutputTo('/var/www/go/storage/logs/amz_items_amazon_cron.log');
                        }
                    }
                    if ($settings->orders_download_cron) {
                        if ($settings->orders_download_cron_frequency == 'Twice a Day') {
                            $schedule->command('amazon:get-orders Fr')->everyFourHours()->withoutOverlapping()->sendOutputTo('/var/www/go/storage/logs/amz_orderscron.log');
                        }
                        if ($settings->orders_download_cron_frequency == 'Once a Day') {
                            $schedule->command('amazon:get-orders Fr')->dailyAt('00:01')->withoutOverlapping()->sendOutputTo('/var/www/go/storage/logs/amz_orderscron.log');
                        }
                        if ($settings->orders_download_cron_frequency == 'Every 2 Days') {
                            $schedule->command('amazon:get-orders Fr')->weekly()->days([1,3])->at('6:00')->withoutOverlapping()->sendOutputTo('/var/www/go/storage/logs/amz_orderscron.log');
                        }
                        if ($settings->orders_download_cron_frequency == 'Every 3 Days') {
                            $schedule->command('amazon:get-orders Fr')->weekly()->days([1,3,5,7])->at('00:01')->withoutOverlapping()->sendOutputTo('/var/www/go/storage/logs/amz_orderscron.log');
                        }
                        if ($settings->orders_download_cron_frequency == 'Every Week') {
                            $schedule->command('amazon:get-orders Fr')->weekly()->withoutOverlapping()->sendOutputTo('/var/www/go/storage/logs/amz_orderscron.log');
                        }
                    }
                    if ($settings->items_update_in_erp_cron) {
                        if ($settings->items_update_in_erp_cron_frequency == 'Twice a Day') {
                            $schedule->command('amazon:update-items-erp Fr')->everyFourHours()->withoutOverlapping()->sendOutputTo('/var/www/go/storage/logs/amz_items_erp_cron.log');
                        }
                        if ($settings->items_update_in_erp_cron_frequency == 'Once a Day') {
                            $schedule->command('amazon:update-items-erp Fr')->dailyAt('01:01')->withoutOverlapping()->sendOutputTo('/var/www/go/storage/logs/amz_items_erp_cron.log');
                        }
                        if ($settings->items_update_in_erp_cron_frequency == 'Every 2 Days') {
                            $schedule->command('amazon:update-items-erp Fr')->weekly()->days([1,3])->at('5:00')->withoutOverlapping()->sendOutputTo('/var/www/go/storage/logs/amz_items_erp_cron.log');
                        }
                        if ($settings->items_update_in_erp_cron_frequency == 'Every 3 Days') {
                            $schedule->command('amazon:update-items-erp Fr')->weekly()->days([1,3,5,7])->at('01:01')->withoutOverlapping()->sendOutputTo('/var/www/go/storage/logs/amz_items_erp_cron.log');
                        }
                        if ($settings->items_update_in_erp_cron_frequency == 'Every Week') {
                            $schedule->command('amazon:update-items-erp Fr')->weeklyOn(7, '01:01')->withoutOverlapping()->sendOutputTo('/var/www/go/storage/logs/amz_items_erp_cron.log');
                        }
                    }
                }
                if ($settings->it && !empty($settings->it)) {
                    if ($settings->items_update_on_amazon_cron) {
                        if ($settings->items_update_on_amazon_cron_frequency == 'Twice a Day') {
                            $schedule->command('amazon:update-items-amazon It')->everyFourHours()->withoutOverlapping()->sendOutputTo('/var/www/go/storage/logs/amz_items_amazon_cron.log');
                        }
                        if ($settings->items_update_on_amazon_cron_frequency == 'Once a Day') {
                            $schedule->command('amazon:update-items-amazon It')->dailyAt('01:01')->withoutOverlapping()->sendOutputTo('/var/www/go/storage/logs/amz_items_amazon_cron.log');
                        }
                        if ($settings->items_update_on_amazon_cron_frequency == 'Every 2 Days') {
                            $schedule->command('amazon:update-items-amazon It')->weekly()->days([1,3])->at('5:00')->withoutOverlapping()->sendOutputTo('/var/www/go/storage/logs/amz_items_amazon_cron.log');
                        }
                        if ($settings->items_update_on_amazon_cron_frequency == 'Every 3 Days') {
                            $schedule->command('amazon:update-items-amazon It')->weekly()->days([1,3,5,7])->at('01:01')->withoutOverlapping()->sendOutputTo('/var/www/go/storage/logs/amz_items_amazon_cron.log');
                        }
                        if ($settings->items_update_on_amazon_cron_frequency == 'Every Week') {
                            $schedule->command('amazon:update-items-amazon It')->weeklyOn(7, '01:01')->withoutOverlapping()->sendOutputTo('/var/www/go/storage/logs/amz_items_amazon_cron.log');
                        }
                    }
                    if ($settings->orders_download_cron) {
                        if ($settings->orders_download_cron_frequency == 'Twice a Day') {
                            $schedule->command('amazon:get-orders It')->everyFourHours()->withoutOverlapping()->sendOutputTo('/var/www/go/storage/logs/amz_orderscron.log');
                        }
                        if ($settings->orders_download_cron_frequency == 'Once a Day') {
                            $schedule->command('amazon:get-orders It')->dailyAt('00:01')->withoutOverlapping()->sendOutputTo('/var/www/go/storage/logs/amz_orderscron.log');
                        }
                        if ($settings->orders_download_cron_frequency == 'Every 2 Days') {
                            $schedule->command('amazon:get-orders It')->weekly()->days([1,3])->at('6:00')->withoutOverlapping()->sendOutputTo('/var/www/go/storage/logs/amz_orderscron.log');
                        }
                        if ($settings->orders_download_cron_frequency == 'Every 3 Days') {
                            $schedule->command('amazon:get-orders It')->weekly()->days([1,3,5,7])->at('00:01')->withoutOverlapping()->sendOutputTo('/var/www/go/storage/logs/amz_orderscron.log');
                        }
                        if ($settings->orders_download_cron_frequency == 'Every Week') {
                            $schedule->command('amazon:get-orders It')->weekly()->withoutOverlapping()->sendOutputTo('/var/www/go/storage/logs/amz_orderscron.log');
                        }
                    }
                    if ($settings->items_update_in_erp_cron) {
                        if ($settings->items_update_in_erp_cron_frequency == 'Twice a Day') {
                            $schedule->command('amazon:update-items-erp It')->everyFourHours()->withoutOverlapping()->sendOutputTo('/var/www/go/storage/logs/amz_items_erp_cron.log');
                        }
                        if ($settings->items_update_in_erp_cron_frequency == 'Once a Day') {
                            $schedule->command('amazon:update-items-erp It')->dailyAt('01:01')->withoutOverlapping()->sendOutputTo('/var/www/go/storage/logs/amz_items_erp_cron.log');
                        }
                        if ($settings->items_update_in_erp_cron_frequency == 'Every 2 Days') {
                            $schedule->command('amazon:update-items-erp It')->weekly()->days([1,3])->at('5:00')->withoutOverlapping()->sendOutputTo('/var/www/go/storage/logs/amz_items_erp_cron.log');
                        }
                        if ($settings->items_update_in_erp_cron_frequency == 'Every 3 Days') {
                            $schedule->command('amazon:update-items-erp It')->weekly()->days([1,3,5,7])->at('01:01')->withoutOverlapping()->sendOutputTo('/var/www/go/storage/logs/amz_items_erp_cron.log');
                        }
                        if ($settings->items_update_in_erp_cron_frequency == 'Every Week') {
                            $schedule->command('amazon:update-items-erp It')->weeklyOn(7, '01:01')->withoutOverlapping()->sendOutputTo('/var/www/go/storage/logs/amz_items_erp_cron.log');
                        }
                    }
                }
                if ($settings->es && !empty($settings->es)) {
                    if ($settings->items_update_on_amazon_cron) {
                        if ($settings->items_update_on_amazon_cron_frequency == 'Twice a Day') {
                            $schedule->command('amazon:update-items-amazon Es')->everyFourHours()->withoutOverlapping()->sendOutputTo('/var/www/go/storage/logs/amz_items_amazon_cron.log');
                        }
                        if ($settings->items_update_on_amazon_cron_frequency == 'Once a Day') {
                            $schedule->command('amazon:update-items-amazon Es')->dailyAt('01:01')->withoutOverlapping()->sendOutputTo('/var/www/go/storage/logs/amz_items_amazon_cron.log');
                        }
                        if ($settings->items_update_on_amazon_cron_frequency == 'Every 2 Days') {
                            $schedule->command('amazon:update-items-amazon Es')->weekly()->days([1,3])->at('5:00')->withoutOverlapping()->sendOutputTo('/var/www/go/storage/logs/amz_items_amazon_cron.log');
                        }
                        if ($settings->items_update_on_amazon_cron_frequency == 'Every 3 Days') {
                            $schedule->command('amazon:update-items-amazon Es')->weekly()->days([1,3,5,7])->at('01:01')->withoutOverlapping()->sendOutputTo('/var/www/go/storage/logs/amz_items_amazon_cron.log');
                        }
                        if ($settings->items_update_on_amazon_cron_frequency == 'Every Week') {
                            $schedule->command('amazon:update-items-amazon Es')->weeklyOn(7, '01:01')->withoutOverlapping()->sendOutputTo('/var/www/go/storage/logs/amz_items_amazon_cron.log');
                        }
                    }
                    if ($settings->orders_download_cron) {
                        if ($settings->orders_download_cron_frequency == 'Twice a Day') {
                            $schedule->command('amazon:get-orders Es')->everyFourHours()->withoutOverlapping()->sendOutputTo('/var/www/go/storage/logs/amz_orderscron.log');
                        }
                        if ($settings->orders_download_cron_frequency == 'Once a Day') {
                            $schedule->command('amazon:get-orders Es')->dailyAt('00:01')->withoutOverlapping()->sendOutputTo('/var/www/go/storage/logs/amz_orderscron.log');
                        }
                        if ($settings->orders_download_cron_frequency == 'Every 2 Days') {
                            $schedule->command('amazon:get-orders Es')->weekly()->days([1,3])->at('6:00')->withoutOverlapping()->sendOutputTo('/var/www/go/storage/logs/amz_orderscron.log');
                        }
                        if ($settings->orders_download_cron_frequency == 'Every 3 Days') {
                            $schedule->command('amazon:get-orders Es')->weekly()->days([1,3,5,7])->at('00:01')->withoutOverlapping()->sendOutputTo('/var/www/go/storage/logs/amz_orderscron.log');
                        }
                        if ($settings->orders_download_cron_frequency == 'Every Week') {
                            $schedule->command('amazon:get-orders Es')->weekly()->withoutOverlapping()->sendOutputTo('/var/www/go/storage/logs/amz_orderscron.log');
                        }
                    }
                    if ($settings->items_update_in_erp_cron) {
                        if ($settings->items_update_in_erp_cron_frequency == 'Twice a Day') {
                            $schedule->command('amazon:update-items-erp Es')->everyFourHours()->withoutOverlapping()->sendOutputTo('/var/www/go/storage/logs/amz_items_erp_cron.log');
                        }
                        if ($settings->items_update_in_erp_cron_frequency == 'Once a Day') {
                            $schedule->command('amazon:update-items-erp Es')->dailyAt('01:01')->withoutOverlapping()->sendOutputTo('/var/www/go/storage/logs/amz_items_erp_cron.log');
                        }
                        if ($settings->items_update_in_erp_cron_frequency == 'Every 2 Days') {
                            $schedule->command('amazon:update-items-erp Es')->weekly()->days([1,3])->at('5:00')->withoutOverlapping()->sendOutputTo('/var/www/go/storage/logs/amz_items_erp_cron.log');
                        }
                        if ($settings->items_update_in_erp_cron_frequency == 'Every 3 Days') {
                            $schedule->command('amazon:update-items-erp Es')->weekly()->days([1,3,5,7])->at('01:01')->withoutOverlapping()->sendOutputTo('/var/www/go/storage/logs/amz_items_erp_cron.log');
                        }
                        if ($settings->items_update_in_erp_cron_frequency == 'Every Week') {
                            $schedule->command('amazon:update-items-erp Es')->weeklyOn(7, '01:01')->withoutOverlapping()->sendOutputTo('/var/www/go/storage/logs/amz_items_erp_cron.log');
                        }
                    }
                }
                if ($settings->se && !empty($settings->se)) {
                    if ($settings->items_update_on_amazon_cron) {
                        if ($settings->items_update_on_amazon_cron_frequency == 'Twice a Day') {
                            $schedule->command('amazon:update-items-amazon Se')->everyFourHours()->withoutOverlapping()->sendOutputTo('/var/www/go/storage/logs/amz_items_amazon_cron.log');
                        }
                        if ($settings->items_update_on_amazon_cron_frequency == 'Once a Day') {
                            $schedule->command('amazon:update-items-amazon Se')->dailyAt('01:01')->withoutOverlapping()->sendOutputTo('/var/www/go/storage/logs/amz_items_amazon_cron.log');
                        }
                        if ($settings->items_update_on_amazon_cron_frequency == 'Every 2 Days') {
                            $schedule->command('amazon:update-items-amazon Se')->weekly()->days([1,3])->at('5:00')->withoutOverlapping()->sendOutputTo('/var/www/go/storage/logs/amz_items_amazon_cron.log');
                        }
                        if ($settings->items_update_on_amazon_cron_frequency == 'Every 3 Days') {
                            $schedule->command('amazon:update-items-amazon Se')->weekly()->days([1,3,5,7])->at('01:01')->withoutOverlapping()->sendOutputTo('/var/www/go/storage/logs/amz_items_amazon_cron.log');
                        }
                        if ($settings->items_update_on_amazon_cron_frequency == 'Every Week') {
                            $schedule->command('amazon:update-items-amazon Se')->weeklyOn(7, '01:01')->withoutOverlapping()->sendOutputTo('/var/www/go/storage/logs/amz_items_amazon_cron.log');
                        }
                    }
                    if ($settings->orders_download_cron) {
                        if ($settings->orders_download_cron_frequency == 'Twice a Day') {
                            $schedule->command('amazon:get-orders Se')->everyFourHours()->withoutOverlapping()->sendOutputTo('/var/www/go/storage/logs/amz_orderscron.log');
                        }
                        if ($settings->orders_download_cron_frequency == 'Once a Day') {
                            $schedule->command('amazon:get-orders Se')->dailyAt('00:01')->withoutOverlapping()->sendOutputTo('/var/www/go/storage/logs/amz_orderscron.log');
                        }
                        if ($settings->orders_download_cron_frequency == 'Every 2 Days') {
                            $schedule->command('amazon:get-orders Se')->weekly()->days([1,3])->at('6:00')->withoutOverlapping()->sendOutputTo('/var/www/go/storage/logs/amz_orderscron.log');
                        }
                        if ($settings->orders_download_cron_frequency == 'Every 3 Days') {
                            $schedule->command('amazon:get-orders Se')->weekly()->days([1,3,5,7])->at('00:01')->withoutOverlapping()->sendOutputTo('/var/www/go/storage/logs/amz_orderscron.log');
                        }
                        if ($settings->orders_download_cron_frequency == 'Every Week') {
                            $schedule->command('amazon:get-orders Se')->weekly()->withoutOverlapping()->sendOutputTo('/var/www/go/storage/logs/amz_orderscron.log');
                        }
                    }
                    if ($settings->items_update_in_erp_cron) {
                        if ($settings->items_update_in_erp_cron_frequency == 'Twice a Day') {
                            $schedule->command('amazon:update-items-erp Se')->everyFourHours()->withoutOverlapping()->sendOutputTo('/var/www/go/storage/logs/amz_items_erp_cron.log');
                        }
                        if ($settings->items_update_in_erp_cron_frequency == 'Once a Day') {
                            $schedule->command('amazon:update-items-erp Se')->dailyAt('01:01')->withoutOverlapping()->sendOutputTo('/var/www/go/storage/logs/amz_items_erp_cron.log');
                        }
                        if ($settings->items_update_in_erp_cron_frequency == 'Every 2 Days') {
                            $schedule->command('amazon:update-items-erp Se')->weekly()->days([1,3])->at('5:00')->withoutOverlapping()->sendOutputTo('/var/www/go/storage/logs/amz_items_erp_cron.log');
                        }
                        if ($settings->items_update_in_erp_cron_frequency == 'Every 3 Days') {
                            $schedule->command('amazon:update-items-erp Se')->weekly()->days([1,3,5,7])->at('01:01')->withoutOverlapping()->sendOutputTo('/var/www/go/storage/logs/amz_items_erp_cron.log');
                        }
                        if ($settings->items_update_in_erp_cron_frequency == 'Every Week') {
                            $schedule->command('amazon:update-items-erp Se')->weeklyOn(7, '01:01')->withoutOverlapping()->sendOutputTo('/var/www/go/storage/logs/amz_items_erp_cron.log');
                        }
                    }
                }
                if ($settings->nl && !empty($settings->nl)) {
                    if ($settings->items_update_on_amazon_cron) {
                        if ($settings->items_update_on_amazon_cron_frequency == 'Twice a Day') {
                            $schedule->command('amazon:update-items-amazon Nl')->everyFourHours()->withoutOverlapping()->sendOutputTo('/var/www/go/storage/logs/amz_items_amazon_cron.log');
                        }
                        if ($settings->items_update_on_amazon_cron_frequency == 'Once a Day') {
                            $schedule->command('amazon:update-items-amazon Nl')->dailyAt('01:01')->withoutOverlapping()->sendOutputTo('/var/www/go/storage/logs/amz_items_amazon_cron.log');
                        }
                        if ($settings->items_update_on_amazon_cron_frequency == 'Every 2 Days') {
                            $schedule->command('amazon:update-items-amazon Nl')->weekly()->days([1,3])->at('5:00')->withoutOverlapping()->sendOutputTo('/var/www/go/storage/logs/amz_items_amazon_cron.log');
                        }
                        if ($settings->items_update_on_amazon_cron_frequency == 'Every 3 Days') {
                            $schedule->command('amazon:update-items-amazon Nl')->weekly()->days([1,3,5,7])->at('01:01')->withoutOverlapping()->sendOutputTo('/var/www/go/storage/logs/amz_items_amazon_cron.log');
                        }
                        if ($settings->items_update_on_amazon_cron_frequency == 'Every Week') {
                            $schedule->command('amazon:update-items-amazon Nl')->weeklyOn(7, '01:01')->withoutOverlapping()->sendOutputTo('/var/www/go/storage/logs/amz_items_amazon_cron.log');
                        }
                    }
                    if ($settings->orders_download_cron) {
                        if ($settings->orders_download_cron_frequency == 'Twice a Day') {
                            $schedule->command('amazon:get-orders Nl')->everyFourHours()->withoutOverlapping()->sendOutputTo('/var/www/go/storage/logs/amz_orderscron.log');
                        }
                        if ($settings->orders_download_cron_frequency == 'Once a Day') {
                            $schedule->command('amazon:get-orders Nl')->dailyAt('00:01')->withoutOverlapping()->sendOutputTo('/var/www/go/storage/logs/amz_orderscron.log');
                        }
                        if ($settings->orders_download_cron_frequency == 'Every 2 Days') {
                            $schedule->command('amazon:get-orders Nl')->weekly()->days([1,3])->at('6:00')->withoutOverlapping()->sendOutputTo('/var/www/go/storage/logs/amz_orderscron.log');
                        }
                        if ($settings->orders_download_cron_frequency == 'Every 3 Days') {
                            $schedule->command('amazon:get-orders Nl')->weekly()->days([1,3,5,7])->at('00:01')->withoutOverlapping()->sendOutputTo('/var/www/go/storage/logs/amz_orderscron.log');
                        }
                        if ($settings->orders_download_cron_frequency == 'Every Week') {
                            $schedule->command('amazon:get-orders Nl')->weekly()->withoutOverlapping()->sendOutputTo('/var/www/go/storage/logs/amz_orderscron.log');
                        }
                    }
                    if ($settings->items_update_in_erp_cron) {
                        if ($settings->items_update_in_erp_cron_frequency == 'Twice a Day') {
                            $schedule->command('amazon:update-items-erp Nl')->everyFourHours()->withoutOverlapping()->sendOutputTo('/var/www/go/storage/logs/amz_items_erp_cron.log');
                        }
                        if ($settings->items_update_in_erp_cron_frequency == 'Once a Day') {
                            $schedule->command('amazon:update-items-erp Nl')->dailyAt('01:01')->withoutOverlapping()->sendOutputTo('/var/www/go/storage/logs/amz_items_erp_cron.log');
                        }
                        if ($settings->items_update_in_erp_cron_frequency == 'Every 2 Days') {
                            $schedule->command('amazon:update-items-erp Nl')->weekly()->days([1,3])->at('5:00')->withoutOverlapping()->sendOutputTo('/var/www/go/storage/logs/amz_items_erp_cron.log');
                        }
                        if ($settings->items_update_in_erp_cron_frequency == 'Every 3 Days') {
                            $schedule->command('amazon:update-items-erp Nl')->weekly()->days([1,3,5,7])->at('01:01')->withoutOverlapping()->sendOutputTo('/var/www/go/storage/logs/amz_items_erp_cron.log');
                        }
                        if ($settings->items_update_in_erp_cron_frequency == 'Every Week') {
                            $schedule->command('amazon:update-items-erp Nl')->weeklyOn(7, '01:01')->withoutOverlapping()->sendOutputTo('/var/www/go/storage/logs/amz_items_erp_cron.log');
                        }
                    }
                }
                if ($settings->pl && !empty($settings->pl)) {
                    if ($settings->items_update_on_amazon_cron) {
                        if ($settings->items_update_on_amazon_cron_frequency == 'Twice a Day') {
                            $schedule->command('amazon:update-items-amazon Pl')->everyFourHours()->withoutOverlapping()->sendOutputTo('/var/www/go/storage/logs/amz_items_amazon_cron.log');
                        }
                        if ($settings->items_update_on_amazon_cron_frequency == 'Once a Day') {
                            $schedule->command('amazon:update-items-amazon Pl')->dailyAt('01:01')->withoutOverlapping()->sendOutputTo('/var/www/go/storage/logs/amz_items_amazon_cron.log');
                        }
                        if ($settings->items_update_on_amazon_cron_frequency == 'Every 2 Days') {
                            $schedule->command('amazon:update-items-amazon Pl')->weekly()->days([1,3])->at('5:00')->withoutOverlapping()->sendOutputTo('/var/www/go/storage/logs/amz_items_amazon_cron.log');
                        }
                        if ($settings->items_update_on_amazon_cron_frequency == 'Every 3 Days') {
                            $schedule->command('amazon:update-items-amazon Pl')->weekly()->days([1,3,5,7])->at('01:01')->withoutOverlapping()->sendOutputTo('/var/www/go/storage/logs/amz_items_amazon_cron.log');
                        }
                        if ($settings->items_update_on_amazon_cron_frequency == 'Every Week') {
                            $schedule->command('amazon:update-items-amazon Pl')->weeklyOn(7, '01:01')->withoutOverlapping()->sendOutputTo('/var/www/go/storage/logs/amz_items_amazon_cron.log');
                        }
                    }
                    if ($settings->orders_download_cron) {
                        if ($settings->orders_download_cron_frequency == 'Twice a Day') {
                            $schedule->command('amazon:get-orders Pl')->everyFourHours()->withoutOverlapping()->sendOutputTo('/var/www/go/storage/logs/amz_orderscron.log');
                        }
                        if ($settings->orders_download_cron_frequency == 'Once a Day') {
                            $schedule->command('amazon:get-orders Pl')->dailyAt('00:01')->withoutOverlapping()->sendOutputTo('/var/www/go/storage/logs/amz_orderscron.log');
                        }
                        if ($settings->orders_download_cron_frequency == 'Every 2 Days') {
                            $schedule->command('amazon:get-orders Pl')->weekly()->days([1,3])->at('6:00')->withoutOverlapping()->sendOutputTo('/var/www/go/storage/logs/amz_orderscron.log');
                        }
                        if ($settings->orders_download_cron_frequency == 'Every 3 Days') {
                            $schedule->command('amazon:get-orders Pl')->weekly()->days([1,3,5,7])->at('00:01')->withoutOverlapping()->sendOutputTo('/var/www/go/storage/logs/amz_orderscron.log');
                        }
                        if ($settings->orders_download_cron_frequency == 'Every Week') {
                            $schedule->command('amazon:get-orders Pl')->weekly()->withoutOverlapping()->sendOutputTo('/var/www/go/storage/logs/amz_orderscron.log');
                        }
                    }
                    if ($settings->items_update_in_erp_cron) {
                        if ($settings->items_update_in_erp_cron_frequency == 'Twice a Day') {
                            $schedule->command('amazon:update-items-erp Pl')->everyFourHours()->withoutOverlapping()->sendOutputTo('/var/www/go/storage/logs/amz_items_erp_cron.log');
                        }
                        if ($settings->items_update_in_erp_cron_frequency == 'Once a Day') {
                            $schedule->command('amazon:update-items-erp Pl')->dailyAt('01:01')->withoutOverlapping()->sendOutputTo('/var/www/go/storage/logs/amz_items_erp_cron.log');
                        }
                        if ($settings->items_update_in_erp_cron_frequency == 'Every 2 Days') {
                            $schedule->command('amazon:update-items-erp Pl')->weekly()->days([1,3])->at('5:00')->withoutOverlapping()->sendOutputTo('/var/www/go/storage/logs/amz_items_erp_cron.log');
                        }
                        if ($settings->items_update_in_erp_cron_frequency == 'Every 3 Days') {
                            $schedule->command('amazon:update-items-erp Pl')->weekly()->days([1,3,5,7])->at('01:01')->withoutOverlapping()->sendOutputTo('/var/www/go/storage/logs/amz_items_erp_cron.log');
                        }
                        if ($settings->items_update_in_erp_cron_frequency == 'Every Week') {
                            $schedule->command('amazon:update-items-erp Pl')->weeklyOn(7, '01:01')->withoutOverlapping()->sendOutputTo('/var/www/go/storage/logs/amz_items_erp_cron.log');
                        }
                    }
                }
                if ($settings->us && !empty($settings->us)) {
                    if ($settings->items_update_on_amazon_cron) {
                        if ($settings->items_update_on_amazon_cron_frequency == 'Twice a Day') {
                            $schedule->command('amazon:update-items-amazon Us')->everyFourHours()->withoutOverlapping()->sendOutputTo('/var/www/go/storage/logs/amz_items_amazon_cron.log');
                        }
                        if ($settings->items_update_on_amazon_cron_frequency == 'Once a Day') {
                            $schedule->command('amazon:update-items-amazon Us')->dailyAt('01:01')->withoutOverlapping()->sendOutputTo('/var/www/go/storage/logs/amz_items_amazon_cron.log');
                        }
                        if ($settings->items_update_on_amazon_cron_frequency == 'Every 2 Days') {
                            $schedule->command('amazon:update-items-amazon Us')->weekly()->days([1,3])->at('5:00')->withoutOverlapping()->sendOutputTo('/var/www/go/storage/logs/amz_items_amazon_cron.log');
                        }
                        if ($settings->items_update_on_amazon_cron_frequency == 'Every 3 Days') {
                            $schedule->command('amazon:update-items-amazon Us')->weekly()->days([1,3,5,7])->at('01:01')->withoutOverlapping()->sendOutputTo('/var/www/go/storage/logs/amz_items_amazon_cron.log');
                        }
                        if ($settings->items_update_on_amazon_cron_frequency == 'Every Week') {
                            $schedule->command('amazon:update-items-amazon Us')->weeklyOn(7, '01:01')->withoutOverlapping()->sendOutputTo('/var/www/go/storage/logs/amz_items_amazon_cron.log');
                        }
                    }
                    if ($settings->orders_download_cron) {
                        if ($settings->orders_download_cron_frequency == 'Twice a Day') {
                            $schedule->command('amazon:get-orders Us')->everyFourHours()->withoutOverlapping()->sendOutputTo('/var/www/go/storage/logs/amz_orderscron.log');
                        }
                        if ($settings->orders_download_cron_frequency == 'Once a Day') {
                            $schedule->command('amazon:get-orders Us')->dailyAt('00:01')->withoutOverlapping()->sendOutputTo('/var/www/go/storage/logs/amz_orderscron.log');
                        }
                        if ($settings->orders_download_cron_frequency == 'Every 2 Days') {
                            $schedule->command('amazon:get-orders Us')->weekly()->days([1,3])->at('6:00')->withoutOverlapping()->sendOutputTo('/var/www/go/storage/logs/amz_orderscron.log');
                        }
                        if ($settings->orders_download_cron_frequency == 'Every 3 Days') {
                            $schedule->command('amazon:get-orders Us')->weekly()->days([1,3,5,7])->at('00:01')->withoutOverlapping()->sendOutputTo('/var/www/go/storage/logs/amz_orderscron.log');
                        }
                        if ($settings->orders_download_cron_frequency == 'Every Week') {
                            $schedule->command('amazon:get-orders Us')->weekly()->withoutOverlapping()->sendOutputTo('/var/www/go/storage/logs/amz_orderscron.log');
                        }
                    }
                    if ($settings->items_update_in_erp_cron) {
                        if ($settings->items_update_in_erp_cron_frequency == 'Twice a Day') {
                            $schedule->command('amazon:update-items-erp Us')->everyFourHours()->withoutOverlapping()->sendOutputTo('/var/www/go/storage/logs/amz_items_erp_cron.log');
                        }
                        if ($settings->items_update_in_erp_cron_frequency == 'Once a Day') {
                            $schedule->command('amazon:update-items-erp Us')->dailyAt('01:01')->withoutOverlapping()->sendOutputTo('/var/www/go/storage/logs/amz_items_erp_cron.log');
                        }
                        if ($settings->items_update_in_erp_cron_frequency == 'Every 2 Days') {
                            $schedule->command('amazon:update-items-erp Us')->weekly()->days([1,3])->at('5:00')->withoutOverlapping()->sendOutputTo('/var/www/go/storage/logs/amz_items_erp_cron.log');
                        }
                        if ($settings->items_update_in_erp_cron_frequency == 'Every 3 Days') {
                            $schedule->command('amazon:update-items-erp Us')->weekly()->days([1,3,5,7])->at('01:01')->withoutOverlapping()->sendOutputTo('/var/www/go/storage/logs/amz_items_erp_cron.log');
                        }
                        if ($settings->items_update_in_erp_cron_frequency == 'Every Week') {
                            $schedule->command('amazon:update-items-erp Us')->weeklyOn(7, '01:01')->withoutOverlapping()->sendOutputTo('/var/www/go/storage/logs/amz_items_erp_cron.log');
                        }
                    }
                }
                if ($settings->ca && !empty($settings->ca)) {
                    if ($settings->items_update_on_amazon_cron) {
                        if ($settings->items_update_on_amazon_cron_frequency == 'Twice a Day') {
                            $schedule->command('amazon:update-items-amazon Ca')->everyFourHours()->withoutOverlapping()->sendOutputTo('/var/www/go/storage/logs/amz_items_amazon_cron.log');
                        }
                        if ($settings->items_update_on_amazon_cron_frequency == 'Once a Day') {
                            $schedule->command('amazon:update-items-amazon Ca')->dailyAt('01:01')->withoutOverlapping()->sendOutputTo('/var/www/go/storage/logs/amz_items_amazon_cron.log');
                        }
                        if ($settings->items_update_on_amazon_cron_frequency == 'Every 2 Days') {
                            $schedule->command('amazon:update-items-amazon Ca')->weekly()->days([1,3])->at('5:00')->withoutOverlapping()->sendOutputTo('/var/www/go/storage/logs/amz_items_amazon_cron.log');
                        }
                        if ($settings->items_update_on_amazon_cron_frequency == 'Every 3 Days') {
                            $schedule->command('amazon:update-items-amazon Ca')->weekly()->days([1,3,5,7])->at('01:01')->withoutOverlapping()->sendOutputTo('/var/www/go/storage/logs/amz_items_amazon_cron.log');
                        }
                        if ($settings->items_update_on_amazon_cron_frequency == 'Every Week') {
                            $schedule->command('amazon:update-items-amazon Ca')->weeklyOn(7, '01:01')->withoutOverlapping()->sendOutputTo('/var/www/go/storage/logs/amz_items_amazon_cron.log');
                        }
                    }
                    if ($settings->orders_download_cron) {
                        if ($settings->orders_download_cron_frequency == 'Twice a Day') {
                            $schedule->command('amazon:get-orders Ca')->everyFourHours()->withoutOverlapping()->sendOutputTo('/var/www/go/storage/logs/amz_orderscron.log');
                        }
                        if ($settings->orders_download_cron_frequency == 'Once a Day') {
                            $schedule->command('amazon:get-orders Ca')->dailyAt('00:01')->withoutOverlapping()->sendOutputTo('/var/www/go/storage/logs/amz_orderscron.log');
                        }
                        if ($settings->orders_download_cron_frequency == 'Every 2 Days') {
                            $schedule->command('amazon:get-orders Ca')->weekly()->days([1,3])->at('6:00')->withoutOverlapping()->sendOutputTo('/var/www/go/storage/logs/amz_orderscron.log');
                        }
                        if ($settings->orders_download_cron_frequency == 'Every 3 Days') {
                            $schedule->command('amazon:get-orders Ca')->weekly()->days([1,3,5,7])->at('00:01')->withoutOverlapping()->sendOutputTo('/var/www/go/storage/logs/amz_orderscron.log');
                        }
                        if ($settings->orders_download_cron_frequency == 'Every Week') {
                            $schedule->command('amazon:get-orders Ca')->weekly()->withoutOverlapping()->sendOutputTo('/var/www/go/storage/logs/amz_orderscron.log');
                        }
                    }
                    if ($settings->items_update_in_erp_cron) {
                        if ($settings->items_update_in_erp_cron_frequency == 'Twice a Day') {
                            $schedule->command('amazon:update-items-erp Ca')->everyFourHours()->withoutOverlapping()->sendOutputTo('/var/www/go/storage/logs/amz_items_erp_cron.log');
                        }
                        if ($settings->items_update_in_erp_cron_frequency == 'Once a Day') {
                            $schedule->command('amazon:update-items-erp Ca')->dailyAt('01:01')->withoutOverlapping()->sendOutputTo('/var/www/go/storage/logs/amz_items_erp_cron.log');
                        }
                        if ($settings->items_update_in_erp_cron_frequency == 'Every 2 Days') {
                            $schedule->command('amazon:update-items-erp Ca')->weekly()->days([1,3])->at('5:00')->withoutOverlapping()->sendOutputTo('/var/www/go/storage/logs/amz_items_erp_cron.log');
                        }
                        if ($settings->items_update_in_erp_cron_frequency == 'Every 3 Days') {
                            $schedule->command('amazon:update-items-erp Ca')->weekly()->days([1,3,5,7])->at('01:01')->withoutOverlapping()->sendOutputTo('/var/www/go/storage/logs/amz_items_erp_cron.log');
                        }
                        if ($settings->items_update_in_erp_cron_frequency == 'Every Week') {
                            $schedule->command('amazon:update-items-erp Ca')->weeklyOn(7, '01:01')->withoutOverlapping()->sendOutputTo('/var/www/go/storage/logs/amz_items_erp_cron.log');
                        }
                    }
                }
            }
        });
    }

    public function register()
    {
    }
}