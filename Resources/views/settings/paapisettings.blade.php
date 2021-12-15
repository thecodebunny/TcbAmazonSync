@extends('layouts.admin')

@section('title', trans_choice('tcb-amazon-sync::general.settings.paname', 1))

@section('content')
    
    @php 
    if (! $pasettings && empty($pasettings)) {
        $api_key = '';
        $api_secret_key = '';
        $associate_tag_uk = '';
        $associate_tag_fr = '';
        $associate_tag_it = '';
        $associate_tag_es = '';
        $associate_tag_se = '';
        $associate_tag_de = '';
        $associate_tag_in = '';
        $associate_tag_nl = '';
        $associate_tag_pl = '';
        $associate_tag_us = '';
        $associate_tag_ca = '';
        $de = 0;
        $uk = 0;
        $fr = 0;
        $it = 0;
        $es = 0;
        $se = 0;
        $nl = 0;
        $pl = 0;
    } else {
        $api_key = $pasettings->api_key;
        $api_secret_key = $pasettings->api_secret_key;
        $associate_tag_uk = $pasettings->associate_tag_uk;
        $associate_tag_de = $pasettings->associate_tag_de;
        $associate_tag_fr = $pasettings->associate_tag_fr;
        $associate_tag_it = $pasettings->associate_tag_it;
        $associate_tag_es = $pasettings->associate_tag_es;
        $associate_tag_se = $pasettings->associate_tag_se;
        $associate_tag_in = $pasettings->associate_tag_in;
        $associate_tag_nl = $pasettings->associate_tag_nl;
        $associate_tag_pl = $pasettings->associate_tag_pl;
        $associate_tag_us = $pasettings->associate_tag_us;
        $associate_tag_ca = $pasettings->associate_tag_ca;
        $de = $pasettings->de;
        $uk = $pasettings->uk;
        $fr = $pasettings->fr;
        $it = $pasettings->it;
        $es = $pasettings->es;
        $se = $pasettings->se;
        $nl = $pasettings->nl;
        $pl = $pasettings->pl;
    }

    @endphp

    {!! Form::open([
        'id' => 'amazonPaApi',
        'route' => 'tcb-amazon-sync.amazon.apisettings.updatepa',
        '@submit.prevent' => 'onSubmit',
        '@keydown' => 'form.errors.clear($event.target.name)',
        'files' => true,
        'role' => 'form',
        'class' => 'form-loading-button',
        'novalidate' => true
    ]) !!}

    <div class="card">
        <div class="card-header">
            {{ trans('tcb-amazon-sync::general.settings.paapi') }}
        </div>

        <div class="card-body">
            <div class="row">
                {{ Form::textGroup('api_key', trans('tcb-amazon-sync::general.settings.apisetting.accesskeyid'), 'lightbulb', ['required' => 'required'], $api_key) }}

                {{ Form::textGroup('api_secret_key', trans('tcb-amazon-sync::general.settings.apisetting.secretkey'), 'fingerprint', ['required' => 'required'], $api_secret_key) }}

                {{ Form::textGroup('associate_tag_uk', trans('tcb-amazon-sync::general.settings.apisetting.associattaguk'), 'user-secret', [], $associate_tag_uk) }}

                {{ Form::textGroup('associate_tag_de', trans('tcb-amazon-sync::general.settings.apisetting.associattagde'), 'user-secret', [], $associate_tag_de) }}

                {{ Form::textGroup('associate_tag_fr', trans('tcb-amazon-sync::general.settings.apisetting.associattagfr'), 'user-secret', [], $associate_tag_fr) }}

                {{ Form::textGroup('associate_tag_it', trans('tcb-amazon-sync::general.settings.apisetting.associattagit'), 'user-secret', [], $associate_tag_it) }}

                {{ Form::textGroup('associate_tag_es', trans('tcb-amazon-sync::general.settings.apisetting.associattages'), 'user-secret', [], $associate_tag_es) }}

                {{ Form::textGroup('associate_tag_se', trans('tcb-amazon-sync::general.settings.apisetting.associattagse'), 'user-secret', [], $associate_tag_se) }}

                {{ Form::textGroup('associate_tag_nl', trans('tcb-amazon-sync::general.settings.apisetting.associattagpl'), 'user-secret', [], $associate_tag_pl) }}

                {{ Form::textGroup('associate_tag_pl', trans('tcb-amazon-sync::general.settings.apisetting.associattagnl'), 'user-secret', [], $associate_tag_nl) }}
                
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