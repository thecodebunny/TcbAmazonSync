@extends('tcb-amazon-sync::layouts.tcbmaster')

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