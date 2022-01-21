@extends('tcb-amazon-sync::layouts.tcbmaster')

@section('title', trans_choice('tcb-amazon-sync::general.settings.mwsname', 1))

@section('content')
    
    @php 
    if (! $mwssettings && empty($mwssettings)) {
        $merchant_id = '';
        $key_id = '';
        $secret_key = '';
        $auth_token = '';
    } else {
        $merchant_id = $mwssettings->merchant_id;
        $key_id = $mwssettings->key_id;
        $secret_key = $mwssettings->secret_key;
        $auth_token = $mwssettings->auth_token;
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