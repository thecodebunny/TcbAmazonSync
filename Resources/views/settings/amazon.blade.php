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
    $items_update_on_amazon_cron = 0;
    $items_update_on_amazon_cron_frequency = '';
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
    $items_update_on_amazon_cron = $settings->items_update_on_amazon_cron;
    $items_update_on_amazon_cron_frequency = $settings->items_update_on_amazon_cron_frequency;
    $orders_download_cron = $settings->orders_download_cron;
    $orders_download_cron_frequency = $settings->orders_download_cron_frequency;
    $orders_update_cron = $settings->orders_update_cron;
    $orders_update_cron_frequency = $settings->orders_update_cron_frequency;
}

@endphp

@section('content')

{!! Form::open([
    'id' => 'amazonSettings',
    'route' => 'tcb-amazon-sync.amazon.settings.update',
    '@submit.prevent' => 'onSubmit',
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
                    <label for="items_update_on_amazon_cron_frequency" class="form-control-label">{{ trans('tcb-amazon-sync::general.settings.itemcronfreq') }}</label>
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
                <input @if($uk) checked="checked" @endif  name="uk" type="checkbox" value="{{ $uk }}" class="tcb-checkbox">
                <label class="tcb-inlineblock" for="">{{ trans('tcb-amazon-sync::general.settings.apisetting.uk') }}</label>
            </div>
            <div class="col-md-4 mb-3">
                <input @if($de) checked="checked" @endif  name="de" type="checkbox" value="{{ $de }}" class="tcb-checkbox">
                <label class="tcb-inlineblock" for="de">{{ trans('tcb-amazon-sync::general.settings.apisetting.de') }}</label>
            </div>
            <div class="col-md-4 mb-3">
                <input @if($fr) checked="checked" @endif  name="fr" type="checkbox" value="{{ $fr }}" class="tcb-checkbox">
                <label class="tcb-inlineblock" for="">{{ trans('tcb-amazon-sync::general.settings.apisetting.fr') }}</label>
            </div>
            <div class="col-md-4 mb-3">
                <input @if($it) checked="checked" @endif  name="it" type="checkbox" value="{{ $it }}" class="tcb-checkbox">
                <label class="tcb-inlineblock" for="">{{ trans('tcb-amazon-sync::general.settings.apisetting.it') }}</label>
            </div>
            <div class="col-md-4 mb-3">
                <input @if($es) checked="checked" @endif  name="es" type="checkbox" value="{{ $es }}" class="tcb-checkbox">
                <label class="tcb-inlineblock" for=""> {{ trans('tcb-amazon-sync::general.settings.apisetting.es') }}</label>
            </div>
            <div class="col-md-4 mb-3">
                <input @if($se) checked="checked" @endif  name="se" type="checkbox" value="{{ $se }}" class="tcb-checkbox">
                <label class="tcb-inlineblock" for="">{{ trans('tcb-amazon-sync::general.settings.apisetting.se') }}</label>
            </div>
            <div class="col-md-4 mb-3">
                <input @if($nl) checked="checked" @endif  name="nl" type="checkbox" value="{{ $nl }}" class="tcb-checkbox">
                <label class="tcb-inlineblock" for="">{{ trans('tcb-amazon-sync::general.settings.apisetting.nl') }}</label>
            </div>
            <div class="col-md-4 mb-3">
                <input @if($pl) checked="checked" @endif  name="pl" type="checkbox" value="{{ $pl }}" class="tcb-checkbox">
                <label class="tcb-inlineblock" for="">{{ trans('tcb-amazon-sync::general.settings.apisetting.pl') }}</label>
            </div>
            <div class="col-md-4 mb-3">
                <input @if($usa) checked="checked" @endif  name="usa" type="checkbox" value="{{ $usa }}" class="tcb-checkbox">
                <label class="tcb-inlineblock" for="">{{ trans('tcb-amazon-sync::general.settings.apisetting.usa') }}</label>
            </div>
            <div class="card-footer with-border col-md-12">
                <h3 class="card-title">{{ trans('tcb-amazon-sync::general.settings.cronupdate') }}</h3>
            </div>
            <div class="col-md-3 mb-3">
                <input @if($items_update_on_amazon_cron) checked="checked" @endif  name="items_update_on_amazon_cron" type="checkbox" value="{{ $items_update_on_amazon_cron }}" class="tcb-checkbox">
                <label class="tcb-inlineblock" for="">{{ trans('tcb-amazon-sync::general.settings.itemcron') }}</label>
            </div>
            
            <div class="form-group col-md-3">
                <label for="items_update_on_amazon_cron_frequency" class="form-control-label">{{ trans('tcb-amazon-sync::general.settings.itemcronfreq') }}</label>
                <select name="items_update_on_amazon_cron_frequency" class="form-control tcb-select">
                    <option value="">{{ trans('tcb-amazon-sync::general.settings.select') }} Option</option>
                    <option value="Every Day" @if($items_update_on_amazon_cron_frequency == 'Every Day') selected @endif>{{ trans('tcb-amazon-sync::general.settings.everyday') }}</option>
                    <option value="Every Day" @if($items_update_on_amazon_cron_frequency == 'Every 2 Days') selected @endif>{{ trans('tcb-amazon-sync::general.settings.every2days') }}</option>
                    <option value="Every Day" @if($items_update_on_amazon_cron_frequency == 'Every 3 Days') selected @endif>{{ trans('tcb-amazon-sync::general.settings.every3days') }}</option>
                    <option value="Every Day" @if($items_update_on_amazon_cron_frequency == 'Every Week') selected @endif>{{ trans('tcb-amazon-sync::general.settings.everyweek') }}</option>
                </select>
            </div>
            
            <div class="col-md-3 mb-3">
                <input @if($orders_download_cron) checked="checked" @endif  name="orders_download_cron" type="checkbox" value="{{ $orders_download_cron }}" class="tcb-checkbox">
                <label class="tcb-inlineblock" for="">{{ trans('tcb-amazon-sync::general.settings.ordercron') }}</label>
            </div>
            
            <div class="form-group col-md-3">
                <label for="orders_download_cron_frequency" class="form-control-label">{{ trans('tcb-amazon-sync::general.settings.ordercronfreq') }}</label>
                <select name="orders_download_cron_frequency" class="form-control tcb-select">
                    <option value="">{{ trans('tcb-amazon-sync::general.settings.select') }} Option</option>
                    <option value="Every Day" @if($orders_download_cron_frequency == 'Every Day') selected @endif>{{ trans('tcb-amazon-sync::general.settings.everyday') }}</option>
                    <option value="Every Day" @if($orders_download_cron_frequency == 'Every 2 Days') selected @endif>{{ trans('tcb-amazon-sync::general.settings.every2days') }}</option>
                    <option value="Every Day" @if($orders_download_cron_frequency == 'Every 3 Days') selected @endif>{{ trans('tcb-amazon-sync::general.settings.every3days') }}</option>
                    <option value="Every Day" @if($orders_download_cron_frequency == 'Every Week') selected @endif>{{ trans('tcb-amazon-sync::general.settings.everyweek') }}</option>
                </select>
            </div>
            
            <div class="col-md-3 mb-3">
                <input @if($orders_update_cron) checked="checked" @endif  name="orders_download_cron" type="checkbox" value="{{ $orders_update_cron }}" class="tcb-checkbox">
                <label class="tcb-inlineblock" for="">{{ trans('tcb-amazon-sync::general.settings.orderupdatecron') }}</label>
            </div>
            
            <div class="form-group col-md-3">
                <label for="orders_download_cron_frequency" class="form-control-label">{{ trans('tcb-amazon-sync::general.settings.orderupdatecronfreq') }}</label>
                <select name="orders_download_cron_frequency" class="form-control tcb-select">
                    <option value="">{{ trans('tcb-amazon-sync::general.settings.select') }} Option</option>
                    <option value="Every Day" @if($orders_download_cron_frequency == 'Twice a Day') selected @endif>{{ trans('tcb-amazon-sync::general.settings.twiceday') }}</option>
                    <option value="Every Day" @if($orders_download_cron_frequency == 'Once a Day') selected @endif>{{ trans('tcb-amazon-sync::general.settings.onceday') }}</option>
                    <option value="Every Day" @if($orders_download_cron_frequency == 'Every 2 Days') selected @endif>{{ trans('tcb-amazon-sync::general.settings.every2days') }}</option>
                    <option value="Every Day" @if($orders_download_cron_frequency == 'Every 3 Days') selected @endif>{{ trans('tcb-amazon-sync::general.settings.every3days') }}</option>
                    <option value="Every Day" @if($orders_download_cron_frequency == 'Every Week') selected @endif>{{ trans('tcb-amazon-sync::general.settings.everyweek') }}</option>
                </select>
            </div>
            
        </div>
    </div>
        
    <div class="card-footer">
        <div class="row save-buttons">
            {{ Form::saveButtons('settings.index') }}
        </div>
    </div>
</div>

{!! Form::close() !!}
@stop