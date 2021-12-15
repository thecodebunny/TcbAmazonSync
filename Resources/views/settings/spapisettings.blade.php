@extends('layouts.admin')

@section('title', trans_choice('tcb-amazon-sync::general.settings.spname', 1))

@section('content')
    
    @php 
    if (! $spsettings){
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
        $de = 0;
        $uk = 0;
        $fr = 0;
        $it = 0;
        $es = 0;
        $se = 0;
        $nl = 0;
        $pl = 0;
    } else {
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
        $de = $spsettings->de;
        $uk = $spsettings->uk;
        $fr = $spsettings->fr;
        $it = $spsettings->it;
        $es = $spsettings->es;
        $se = $spsettings->se;
        $nl = $spsettings->nl;
        $pl = $spsettings->pl;
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
                
                <div class="col-md-6 mb-3">
                    <input @if($uk) checked="checked" @endif  name="uk" type="checkbox" value="{{ $uk }}" class="tcb-checkbox">
                    <label class="tcb-inlineblock tcb-checkbox-label" for="">{{ trans('tcb-amazon-sync::general.settings.apisetting.uk') }}</label>
                </div>
                <div class="col-md-6 mb-3">
                    <input @if($de) checked="checked" @endif  name="de" type="checkbox" value="{{ $de }}" class="tcb-checkbox">
                    <label class="tcb-inlineblock tcb-checkbox-label" for="de">{{ trans('tcb-amazon-sync::general.settings.apisetting.de') }}</label>
                </div>
                <div class="col-md-6 mb-3">
                    <input @if($fr) checked="checked" @endif  name="fr" type="checkbox" value="{{ $fr }}" class="tcb-checkbox">
                    <label class="tcb-inlineblock tcb-checkbox-label" for="">{{ trans('tcb-amazon-sync::general.settings.apisetting.fr') }}</label>
                </div>
                <div class="col-md-6 mb-3">
                    <input @if($it) checked="checked" @endif  name="it" type="checkbox" value="{{ $it }}" class="tcb-checkbox">
                    <label class="tcb-inlineblock tcb-checkbox-label" for="">{{ trans('tcb-amazon-sync::general.settings.apisetting.it') }}</label>
                </div>
                <div class="col-md-6 mb-3">
                    <input @if($es) checked="checked" @endif  name="es" type="checkbox" value="{{ $es }}" class="tcb-checkbox">
                    <label class="tcb-inlineblock tcb-checkbox-label" for=""> {{ trans('tcb-amazon-sync::general.settings.apisetting.es') }}</label>
                </div>
                <div class="col-md-6 mb-3">
                    <input @if($se) checked="checked" @endif  name="se" type="checkbox" value="{{ $se }}" class="tcb-checkbox">
                    <label class="tcb-inlineblock tcb-checkbox-label" for="">{{ trans('tcb-amazon-sync::general.settings.apisetting.se') }}</label>
                </div>
                <div class="col-md-6 mb-3">
                    <input @if($nl) checked="checked" @endif  name="nl" type="checkbox" value="{{ $nl }}" class="tcb-checkbox">
                    <label class="tcb-inlineblock tcb-checkbox-label" for="">{{ trans('tcb-amazon-sync::general.settings.apisetting.nl') }}</label>
                </div>
                <div class="col-md-6 mb-3">
                    <input @if($pl) checked="checked" @endif  name="pl" type="checkbox" value="{{ $pl }}" class="tcb-checkbox">
                    <label class="tcb-inlineblock tcb-checkbox-label" for="">{{ trans('tcb-amazon-sync::general.settings.apisetting.pl') }}</label>
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