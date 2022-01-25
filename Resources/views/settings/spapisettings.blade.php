@extends('tcb-amazon-sync::layouts.tcbmaster')

@section('title', trans_choice('tcb-amazon-sync::general.settings.spname', 1))

@section('content')
    
    @php 
    if (! $spsettings){
        $seller_id = '';
        $app_name = '';
        $app_id = '';
        $client_id = '';
        $client_secret = '';
        $ias_access_key = '';
        $ias_access_token = '';
        $eu_token = '';
        $us_token = '';
        $endpoint = '';
        $iam_arn = '';
    } else {
        $seller_id = $spsettings->seller_id;
        $app_name = $spsettings->app_name;
        $app_id = $spsettings->app_id;
        $client_id = $spsettings->client_id;
        $client_secret = $spsettings->client_secret;
        $ias_access_key = $spsettings->ias_access_key;
        $ias_access_token = $spsettings->ias_access_token;
        $eu_token = $spsettings->eu_token;
        $us_token = $spsettings->us_token;
        $endpoint = $spsettings->endpoint;
        $iam_arn = $spsettings->iam_arn;
    }
    @endphp

    {!! Form::open([
        'id' => 'amazonSpApi',
        'route' => 'tcb-amazon-sync.amazon.apisettings.updatesp',
        '@submit.prevent' => 'onSubmit',
        '@keydown' => 'form.errors.clear($event.target.name)',
        'files' => true,
        'role' => 'form',
        'class' => 'form-loading-button',
        'novalidate' => true
    ]) !!}

    <div class="card">
        <div class="card-header">
            {{ trans('tcb-amazon-sync::general.settings.spapi') }}
        </div>
        <div class="card-body">
            <div class="row">
                {{ Form::textGroup('seller_id', trans('tcb-amazon-sync::general.settings.sellerid'), 'lightbulb', ['required' => 'required'], $seller_id) }}

                {{ Form::textGroup('app_name', trans('tcb-amazon-sync::general.settings.appname'), 'lightbulb', ['required' => 'required'], $app_name) }}

                {{ Form::textGroup('app_id', trans('tcb-amazon-sync::general.settings.appid'), 'fingerprint', ['required' => 'required'], $app_id) }}

                {{ Form::textGroup('client_id', trans('tcb-amazon-sync::general.settings.clientid'), 'burn', [], $client_id) }}

                {{ Form::textGroup('client_secret', trans('tcb-amazon-sync::general.settings.clientsecret'), 'user-secret', [], $client_secret) }}

                {{ Form::textGroup('ias_access_key', trans('tcb-amazon-sync::general.settings.iasaccesskey'), 'key', [], $ias_access_key) }}

                {{ Form::textGroup('ias_access_token', trans('tcb-amazon-sync::general.settings.iasaccesstoken'), 'drumstick-bite', [], $ias_access_token) }}

                {{ Form::textareaGroup('eu_token', trans('tcb-amazon-sync::general.settings.eutoken'), null, $eu_token) }}

                {{ Form::textareaGroup('us_token', trans('tcb-amazon-sync::general.settings.ustoken'), null, $us_token) }}

                {{ Form::textGroup('endpoint', trans('tcb-amazon-sync::general.settings.endpoint'), 'wifi', [], $endpoint) }}

                {{ Form::textGroup('iam_arn', trans('tcb-amazon-sync::general.settings.iamarn'), 'user-astronaut', [], $iam_arn) }}
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