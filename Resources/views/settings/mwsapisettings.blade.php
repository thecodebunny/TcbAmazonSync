@extends('layouts.admin')

@section('title', trans_choice('tcb-amazon-sync::general.settings.mwsname', 1))

@section('content')
    
    @php 
    if (! $mwssettings && empty($mwssettings)) {
        $merchant_id = '';
        $key_id = '';
        $secret_key = '';
        $auth_token = '';
        $de = 0;
        $uk = 0;
        $fr = 0;
        $it = 0;
        $es = 0;
        $se = 0;
        $nl = 0;
        $pl = 0;
    } else {
        $merchant_id = $mwssettings->merchant_id;
        $key_id = $mwssettings->key_id;
        $secret_key = $mwssettings->secret_key;
        $auth_token = $mwssettings->auth_token;
        $de = $mwssettings->de;
        $uk = $mwssettings->uk;
        $fr = $mwssettings->fr;
        $it = $mwssettings->it;
        $es = $mwssettings->es;
        $se = $mwssettings->se;
        $nl = $mwssettings->nl;
        $pl = $mwssettings->pl;
    }

    @endphp

    {!! Form::open([
        'id' => 'amazonMwsApi',
        'route' => 'tcb-amazon-sync.amazon.apisettings.updatemws',
        '@submit.prevent' => 'onSubmit',
        '@keydown' => 'form.errors.clear($event.target.name)',
        'files' => true,
        'role' => 'form',
        'class' => 'form-loading-button',
        'novalidate' => true
    ]) !!}

    <div class="card">
        <div class="card-header">
            {{ trans('tcb-amazon-sync::general.settings.mwsapi') }}
        </div>

        <div class="card-body">
            <div class="row">
                {{ Form::textGroup('merchant_id', trans('tcb-amazon-sync::general.settings.apisetting.merchant'), 'lightbulb', ['required' => 'required'], $merchant_id) }}

                {{ Form::textGroup('key_id', trans('tcb-amazon-sync::general.settings.apisetting.accesskeyid'), 'fingerprint', ['required' => 'required'], $key_id) }}

                {{ Form::textGroup('secret_key', trans('tcb-amazon-sync::general.settings.apisetting.secretkey'), 'burn', ['required' => 'required'], $secret_key) }}

                {{ Form::textGroup('auth_token', trans('tcb-amazon-sync::general.settings.apisetting.authtoken'), 'user-secret', [], $auth_token) }}
                
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

    {!! Form::hidden('_prefix', 'company') !!}

    {!! Form::close() !!}
@stop


@push('scripts_start')
    <script src="{{ asset('modules/TcbAmazonSync/Resources/assets/js/app.js?v=' . module_version('tcb-amazon-sync')) }}"></script>
    <link rel="stylesheet" href="{{ asset('modules/TcbAmazonSync/Resources/assets/css/tcb.css?v=' . module_version('tcb-amazon-sync')) }}" type="text/css">
@endpush