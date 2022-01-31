<?php

namespace Modules\TcbAmazonSync\Http\Controllers\Amazon;

use App\Abstracts\Http\Controller;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request as LRequest;
use Modules\TcbAmazonSync\Models\Amazon\Warehouse;
use Modules\TcbAmazonSync\Models\Amazon\Setting;
use Modules\TcbAmazonSync\Models\Amazon\SpApiSetting;
use Modules\TcbAmazonSync\Models\Amazon\PaApiSetting;
use Modules\TcbAmazonSync\Models\Amazon\MwsApiSetting;
use Modules\TcbAmazonSync\Http\Requests\Settings as SRequest;
use Modules\TcbAmazonSync\Http\Requests\SpApiSetting as SpRequest;
use Modules\TcbAmazonSync\Http\Requests\PaApiSetting as PaRequest;
use Modules\TcbAmazonSync\Http\Requests\MwsApiSetting as MwsRequest;

class Settings extends Controller
{

    public function __construct()
    {
        $this->middleware('admin');
    }

    public function settings(SRequest $request)
    {
        $settings = Setting::where('company_id', Route::current()->originalParameter('company_id'))->first();
        $company_id = Route::current()->originalParameter('company_id');
        $warehouses = Warehouse::where('company_id', Route::current()->originalParameter('company_id'))->get();
        return view('tcb-amazon-sync::settings.amazon', compact('settings', 'company_id', 'warehouses'));
    }
    
    public function update(SRequest $request)
    {
        $settings = Setting::where('company_id', Route::current()->originalParameter('company_id'))->first();
        if (! $settings) { $settings = new Setting; }

        $settings->default_warehouse = $request->get('default_warehouse');
        $settings->de = $request->get('de');
        $settings->fr = $request->get('fr');
        $settings->it = $request->get('it');
        $settings->es = $request->get('es');
        $settings->uk = $request->get('uk');
        $settings->se = $request->get('se');
        $settings->nl = $request->get('nl');
        $settings->pl = $request->get('pl');
        $settings->items_update_on_amazon_cron = $request->get('items_update_on_amazon_cron');
        $settings->items_update_on_amazon_cron_frequency = $request->get('items_update_on_amazon_cron_frequency');
        $settings->orders_download_cron = $request->get('orders_download_cron');
        $settings->orders_download_cron_frequency = $request->get('orders_download_cron_frequency');
        $settings->orders_update_cron = $request->get('orders_update_cron');
        $settings->orders_update_cron_frequency = $request->get('orders_updatecron_frequency');

        $settings->save();
        return redirect(route('tcb-amazon-sync.amazon.settings'));
    }

    public function spapisettings(LRequest $request)
    {
        $spsettings = SpApiSetting::where('company_id',Route::current()->originalParameter('company_id'))->first();
        return view('tcb-amazon-sync::settings.spapisettings', compact('spsettings'));
    }

    public function updateSpApiSettings(SpRequest $request)
    {
        $settings = SpApiSetting::where('company_id', $request->get('company_id'))->first();
        if (! $settings) {$settings = new SpApiSetting;}

        $settings->seller_id = $request->get('seller_id');
        $settings->app_name = $request->get('app_name');
        $settings->app_id = $request->get('app_id');
        $settings->client_id = $request->get('client_id');
        $settings->client_secret = $request->get('client_secret');
        $settings->ias_access_key = $request->get('ias_access_key');
        $settings->ias_access_token = $request->get('ias_access_token');
        $settings->eu_token = $request->get('eu_token');
        $settings->us_token = $request->get('us_token');
        $settings->endpoint = $request->get('endpoint');
        $settings->iam_arn = $request->get('iam_arn');
        $settings->company_id = $request->get('company_id');

        $settings->save();

        $message = trans('tcb-amazon-sync::general.settings.apisetting.updated');
        
        return redirect(route('tcb-amazon-sync.amazon.spapisettings'));
    }

    public function paapisettings(LRequest $request)
    {
        $pasettings = PaApiSetting::where('company_id',Route::current()->originalParameter('company_id'))->first();
        return view('tcb-amazon-sync::settings.paapisettings', compact('pasettings'));
    }

    public function mwsapisettings(LRequest $request)
    {
        $mwssettings = MwsApiSetting::where('company_id',Route::current()->originalParameter('company_id'))->first();
        return view('tcb-amazon-sync::settings.mwsapisettings', compact('mwssettings'));
    }

    public function updatePaApiSettings(PaRequest $request)
    {
        $settings = PaApiSetting::where('company_id', $request->get('company_id'))->first();
        if (! $settings) {$settings = new PaApiSetting;}

        $settings->company_id = $request->get('company_id');
        $settings->api_key = $request->get('api_key');
        $settings->api_secret_key = $request->get('api_secret_key');
        $settings->associate_tag_uk = $request->get('associate_tag_uk');
        $settings->associate_tag_de = $request->get('associate_tag_de');
        $settings->associate_tag_fr = $request->get('associate_tag_fr');
        $settings->associate_tag_it = $request->get('associate_tag_it');
        $settings->associate_tag_es = $request->get('associate_tag_es');
        $settings->associate_tag_se = $request->get('associate_tag_se');
        $settings->associate_tag_nl = $request->get('associate_tag_nl');
        $settings->associate_tag_pl = $request->get('associate_tag_pl');
        $settings->uk = $request->get('uk');
        $settings->de = $request->get('de');
        $settings->fr = $request->get('fr');
        $settings->it = $request->get('it');
        $settings->es = $request->get('es');
        $settings->se = $request->get('se');
        $settings->nl = $request->get('nl');
        $settings->pl = $request->get('pl');

        $settings->save();

        $message = trans('tcb-amazon-sync::general.settings.apisetting.updated');
        
        return redirect(route('tcb-amazon-sync.amazon.paapisettings'));
    }

    public function updateMwsApiSettings(MwsRequest $request)
    {
        $settings = MwsApiSetting::where('company_id', $request->get('company_id'))->first();
        if (! $settings) {$settings = new MwsApiSetting;}

        $settings->merchant_id = $request->get('merchant_id');
        $settings->key_id = $request->get('key_id');
        $settings->secret_key = $request->get('secret_key');
        $settings->auth_token = $request->get('auth_token');
        $settings->company_id = $request->get('company_id');
        $settings->uk = $request->get('uk');
        $settings->de = $request->get('de');
        $settings->fr = $request->get('fr');
        $settings->it = $request->get('it');
        $settings->es = $request->get('es');
        $settings->se = $request->get('se');
        $settings->nl = $request->get('nl');
        $settings->pl = $request->get('pl');

        $settings->save();

        $message = trans('tcb-amazon-sync::general.settings.apisetting.updated');
        
        return redirect(route('tcb-amazon-sync.amazon.mwsapisettings'));
    }

}