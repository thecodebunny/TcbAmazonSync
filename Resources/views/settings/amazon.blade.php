@extends('tcb-amazon-sync::layouts.tcbmaster')

    
@php 
if (! $settings && empty($settings)) {
    $default_warehouse = '';
    $id = '';
    $de = 0;
    $uk = 0;
    $fr = 0;
    $it = 0;
    $es = 0;
    $se = 0;
    $nl = 0;
    $pl = 0;
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