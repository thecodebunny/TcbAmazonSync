@extends('tcb-amazon-sync::layouts.tcbmaster')

    
@php 
if (! $settings && empty($settings)) {
    $default_warehouse = NULL;
    $id = '';
    $de = 0;
    $uk = 0;
    $fr = 0;
    $it = 0;
    $es = 0;
    $se = 0;
    $nl = 0;
    $pl = 0;
    $usa = 0;
    $do_access_key = '';
    $do_secret_key = '';
    $region = '';
    $bucket = '';
    $folder = '';
    $url = '';
    $endpoint = '';
    $items_update_on_amazon_cron = 0;
    $items_update_on_amazon_cron_frequency = '';
    $items_update_in_erp_cron = 0;
    $items_update_in_erp_cron_frequency = '';
    $orders_download_cron = 0;
    $orders_download_cron_frequency = '';
    $orders_update_cron = 0;
    $orders_update_cron_frequency = '';
} else {
    $default_warehouse = $settings->default_warehouse;
    $id = $settings->id;
    $de = $settings->de;
    $uk = $settings->uk;
    $fr = $settings->fr;
    $it = $settings->it;
    $es = $settings->es;
    $se = $settings->se;
    $nl = $settings->nl;
    $pl = $settings->pl;
    $usa = $settings->usa;
    $do_access_key = $settings->do_access_key;
    $do_secret_key = $settings->do_secret_key;
    $region = $settings->region;
    $bucket = $settings->bucket;
    $folder = $settings->folder;
    $url = $settings->url;
    $endpoint = $settings->endpoint;
    $items_update_on_amazon_cron = $settings->items_update_on_amazon_cron;
    $items_update_on_amazon_cron_frequency = $settings->items_update_on_amazon_cron_frequency;
    $items_update_in_erp_cron = $settings->items_update_in_erp_cron;
    $items_update_in_erp_cron_frequency = $settings->items_update_in_erp_cron_frequency;
    $orders_download_cron = $settings->orders_download_cron;
    $orders_download_cron_frequency = $settings->orders_download_cron_frequency;
    $orders_update_cron = $settings->orders_update_cron;
    $orders_update_cron_frequency = $settings->orders_update_cron_frequency;
}

@endphp

@section('title', trans_choice('tcb-amazon-sync::general.settings.amazon', 1))


@section('content')

{!! Form::open([
    'id' => 'amazonSettings',
    'route' => 'tcb-amazon-sync.amazon.settings.update',
    '@keydown' => 'form.errors.clear($event.target.name)',
    'files' => true,
    'role' => 'form',
    'class' => 'form-loading-button',
    'novalidate' => true
]) !!}

<div class="card">
    <div class="card-header">
        {{ trans('tcb-amazon-sync::general.settings.amazon') }}
    </div>

    <div class="card-body">
        <div class="row">
            {!! Form::hidden('company_id', $company_id) !!}
            
            <div class="form-group col-md-12">
                <div class="col-md-6">
                    <label for="items_update_on_amazon_cron_frequency" class="form-control-label">{{ trans('tcb-amazon-sync::general.settings.defaultwarehouse') }}</label>
                    <select name="default_warehouse" class="form-control tcb-select">
                        @if ($warehouses)
                            <option value="">{{ trans('tcb-amazon-sync::general.settings.select') }} Warehouse</option>
                            @foreach ($warehouses as $warehouse)
                                <option value="{{$warehouse->id}}" @if($default_warehouse == $warehouse->id) selected @endif>{{ $warehouse->name }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <label class="tcb-inlineblock" for="uk">{{ trans('tcb-amazon-sync::general.settings.apisetting.uk') }}</label>
                <label class="custom-toggle">
                    <input name ="uk" class="tcb-switch" type="checkbox" {{!empty($uk) ? 'checked' : ''}} value="{{ $uk }}">
                    <span class="custom-toggle-slider rounded-circle" data-label-off="No" data-label-on="Yes"></span>
                </label>
            </div>
            <div class="col-md-4 mb-3">
                <label class="tcb-inlineblock" for="de">{{ trans('tcb-amazon-sync::general.settings.apisetting.de') }}</label>
                <label class="custom-toggle">
                    <input name ="de" class="tcb-switch" type="checkbox" {{!empty($de) ? 'checked' : ''}} value="{{ $de }}">
                    <span class="custom-toggle-slider rounded-circle" data-label-off="No" data-label-on="Yes"></span>
                </label>
            </div>
            <div class="col-md-4 mb-3">
                <label class="tcb-inlineblock" for="fr">{{ trans('tcb-amazon-sync::general.settings.apisetting.fr') }}</label>
                <label class="custom-toggle">
                    <input name ="fr" class="tcb-switch" type="checkbox" {{!empty($fr) ? 'checked' : ''}} value="{{ $fr }}">
                    <span class="custom-toggle-slider rounded-circle" data-label-off="No" data-label-on="Yes"></span>
                </label>
            </div>
            <div class="col-md-4 mb-3">
                <label class="tcb-inlineblock" for="it">{{ trans('tcb-amazon-sync::general.settings.apisetting.it') }}</label>
                <label class="custom-toggle">
                    <input name ="it" class="tcb-switch" type="checkbox" {{!empty($it) ? 'checked' : ''}} value="{{ $it }}">
                    <span class="custom-toggle-slider rounded-circle" data-label-off="No" data-label-on="Yes"></span>
                </label>
            </div>
            <div class="col-md-4 mb-3">
                <label class="tcb-inlineblock" for="es">{{ trans('tcb-amazon-sync::general.settings.apisetting.es') }}</label>
                <label class="custom-toggle">
                    <input name ="es" class="tcb-switch" type="checkbox" {{!empty($es) ? 'checked' : ''}} value="{{ $es }}">
                    <span class="custom-toggle-slider rounded-circle" data-label-off="No" data-label-on="Yes"></span>
                </label>
            </div>
            <div class="col-md-4 mb-3">
                <label class="tcb-inlineblock" for="se">{{ trans('tcb-amazon-sync::general.settings.apisetting.se') }}</label>
                <label class="custom-toggle">
                    <input name ="se" class="tcb-switch" type="checkbox" {{!empty($se) ? 'checked' : ''}} value="{{ $se }}">
                    <span class="custom-toggle-slider rounded-circle" data-label-off="No" data-label-on="Yes"></span>
                </label>
            </div>
            <div class="col-md-4 mb-3">
                <label class="tcb-inlineblock" for="nl">{{ trans('tcb-amazon-sync::general.settings.apisetting.nl') }}</label>
                <label class="custom-toggle">
                    <input name ="nl" class="tcb-switch" type="checkbox" {{!empty($nl) ? 'checked' : ''}} value="{{ $nl }}">
                    <span class="custom-toggle-slider rounded-circle" data-label-off="No" data-label-on="Yes"></span>
                </label>
            </div>
            <div class="col-md-4 mb-3">
                <label class="tcb-inlineblock" for="pl">{{ trans('tcb-amazon-sync::general.settings.apisetting.pl') }}</label>
                <label class="custom-toggle">
                    <input name ="pl" class="tcb-switch" type="checkbox" {{!empty($pl) ? 'checked' : ''}} value="{{ $pl }}">
                    <span class="custom-toggle-slider rounded-circle" data-label-off="No" data-label-on="Yes"></span>
                </label>
            </div>
            <div class="col-md-4 mb-3">
                <label class="tcb-inlineblock" for="usa">{{ trans('tcb-amazon-sync::general.settings.apisetting.usa') }}</label>
                <label class="custom-toggle">
                    <input name ="usa" class="tcb-switch" type="checkbox" {{!empty($usa) ? 'checked' : ''}} value="{{ $usa }}">
                    <span class="custom-toggle-slider rounded-circle" data-label-off="No" data-label-on="Yes"></span>
                </label>
            </div>
            <div class="card-footer with-border col-md-12">
                <h3 class="card-title pb-2">{{ trans('tcb-amazon-sync::general.settings.cronupdate') }}</h3>
            </div>
            <div class="row pt-3 pb-3 col-md-12 border-bottom border-top">

                <div class="col-md-6 mb-3">
                    <input @if($items_update_on_amazon_cron == 'on') checked="checked" @endif  name="items_update_on_amazon_cron" type="checkbox" value="{{ $items_update_on_amazon_cron }}" class="tcb-checkbox">
                    <label class="tcb-inlineblock" for="">{{ trans('tcb-amazon-sync::general.settings.itemcron') }}</label>
                </div>
            
                <div class="form-group col-md-6">
                    <label for="items_update_on_amazon_cron_frequency" class="form-control-label">{{ trans('tcb-amazon-sync::general.settings.itemcronfreq') }}</label>
                    <select name="items_update_on_amazon_cron_frequency" class="form-control tcb-select">
                        <option class="el-select-dropdown__item" value="">{{ trans('tcb-amazon-sync::general.settings.select') }} Option</option>
                        <option class="el-select-dropdown__item" value="Every Day" @if($items_update_on_amazon_cron_frequency == 'Every Day') selected @endif>{{ trans('tcb-amazon-sync::general.settings.everyday') }}</option>
                        <option class="el-select-dropdown__item" value="Every 2 Days" @if($items_update_on_amazon_cron_frequency == 'Every 2 Days') selected @endif>{{ trans('tcb-amazon-sync::general.settings.every2days') }}</option>
                        <option class="el-select-dropdown__item" value="Every 3 Days" @if($items_update_on_amazon_cron_frequency == 'Every 3 Days') selected @endif>{{ trans('tcb-amazon-sync::general.settings.every3days') }}</option>
                        <option class="el-select-dropdown__item" value="Every Week" @if($items_update_on_amazon_cron_frequency == 'Every Week') selected @endif>{{ trans('tcb-amazon-sync::general.settings.everyweek') }}</option>
                    </select>
                </div>

            </div>
            
            <div class="row pt-3 pb-3 col-md-12 border-bottom">
            
                <div class="col-md-6 mb-3">
                    <input @if($items_update_in_erp_cron == 'on') checked="checked" @endif  name="items_update_in_erp_cron" type="checkbox" value="{{ $items_update_in_erp_cron }}" class="tcb-checkbox">
                    <label class="tcb-inlineblock" for="">{{ trans('tcb-amazon-sync::general.settings.itemupdateerpcron') }}</label>
                </div>
                
                <div class="form-group col-md-6">
                    <label for="items_update_in_erp_cron_frequency" class="form-control-label">{{ trans('tcb-amazon-sync::general.settings.itemupdateerpcronfreq') }}</label>
                    <select name="items_update_in_erp_cron_frequency" class="form-control tcb-select">
                        <option class="el-select-dropdown__item" value="">{{ trans('tcb-amazon-sync::general.settings.select') }} Option</option>
                        <option class="el-select-dropdown__item" value="Twice a Day" @if($items_update_in_erp_cron_frequency == 'Twice a Day') selected @endif>{{ trans('tcb-amazon-sync::general.settings.twiceday') }}</option>
                        <option class="el-select-dropdown__item" value="Once a Day" @if($items_update_in_erp_cron_frequency == 'Once a Day') selected @endif>{{ trans('tcb-amazon-sync::general.settings.onceday') }}</option>
                        <option class="el-select-dropdown__item" value="Every 2 Days" @if($items_update_in_erp_cron_frequency == 'Every 2 Days') selected @endif>{{ trans('tcb-amazon-sync::general.settings.every2days') }}</option>
                        <option class="el-select-dropdown__item" value="Every 3 Days" @if($items_update_in_erp_cron_frequency == 'Every 3 Days') selected @endif>{{ trans('tcb-amazon-sync::general.settings.every3days') }}</option>
                        <option class="el-select-dropdown__item" value="Every Week" @if($items_update_in_erp_cron_frequency == 'Every Week') selected @endif>{{ trans('tcb-amazon-sync::general.settings.everyweek') }}</option>
                    </select>
                </div>

            </div>

            <div class="row pt-3 pb-3 col-md-12 border-bottom">
                
                <div class="col-md-6 mb-6">
                    <input @if($orders_download_cron == 'on') checked="checked" @endif  name="orders_download_cron" type="checkbox" value="{{ $orders_download_cron }}" class="tcb-checkbox">
                    <label class="tcb-inlineblock" for="">{{ trans('tcb-amazon-sync::general.settings.ordercron') }}</label>
                </div>
            
                <div class="form-group col-md-6">
                    <label for="orders_download_cron_frequency" class="form-control-label">{{ trans('tcb-amazon-sync::general.settings.ordercronfreq') }}</label>
                    <select name="orders_download_cron_frequency" class="form-control tcb-select">
                        <option class="el-select-dropdown__item" value="">{{ trans('tcb-amazon-sync::general.settings.select') }} Option</option>
                        <option class="el-select-dropdown__item" value="Twice a Day" @if($orders_download_cron_frequency == 'Twice a Day') selected @endif>{{ trans('tcb-amazon-sync::general.settings.twiceday') }}</option>
                        <option class="el-select-dropdown__item" value="Once a Day" @if($orders_download_cron_frequency == 'Once a Day') selected @endif>{{ trans('tcb-amazon-sync::general.settings.onceday') }}</option>
                        <option class="el-select-dropdown__item" value="Every 2 Days" @if($orders_download_cron_frequency == 'Every 2 Days') selected @endif>{{ trans('tcb-amazon-sync::general.settings.every2days') }}</option>
                        <option class="el-select-dropdown__item" value="Every 3 Days" @if($orders_download_cron_frequency == 'Every 3 Days') selected @endif>{{ trans('tcb-amazon-sync::general.settings.every3days') }}</option>
                        <option class="el-select-dropdown__item" value="Every Week" @if($orders_download_cron_frequency == 'Every Week') selected @endif>{{ trans('tcb-amazon-sync::general.settings.everyweek') }}</option>
                    </select>
                </div>

            </div>
            
            <div class="card-footer with-border col-md-12">
                <h3 class="card-title pb-2">{{ trans('tcb-amazon-sync::general.settings.cloudstorage') }}</h3>
            </div>
            {{ Form::textGroup('do_access_key', trans('tcb-amazon-sync::general.settings.do_access_key'), 'wifi', [], $do_access_key) }}
            {{ Form::textGroup('do_secret_key', trans('tcb-amazon-sync::general.settings.do_secret_key'), 'wifi', [], $do_secret_key) }}
            {{ Form::textGroup('region', trans('tcb-amazon-sync::general.settings.region'), 'wifi', [], $region) }}
            {{ Form::textGroup('bucket', trans('tcb-amazon-sync::general.settings.bucket'), 'wifi', [], $bucket) }}
            {{ Form::textGroup('folder', trans('tcb-amazon-sync::general.settings.folder'), 'wifi', [], $folder) }}
            {{ Form::textGroup('url', trans('tcb-amazon-sync::general.settings.url'), 'wifi', [], $url) }}
            {{ Form::textGroup('endpoint', trans('tcb-amazon-sync::general.settings.endpoint'), 'wifi', [], $endpoint) }}
            
        </div>
    </div>
        
    <div class="card-footer">
        <div class="row save-buttons">
            {{ Form::saveButtons('tcb-amazon-sync.amazon.settings') }}
        </div>
    </div>
</div>

{!! Form::close() !!}
@stop