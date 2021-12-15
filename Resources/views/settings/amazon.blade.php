@extends('layouts.admin')

    
@php 
if (! $settings && empty($settings)) {
    $default_warehouse = '';
    $id = '';
} else {
    $default_warehouse = $settings->default_warehouse;
    $id = $settings->id;
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
            <div class="col-md-6">
                <label class="form-control-label" for="enable">Default Warehouse</label>
                {{ Form::select('default_warehouse', $warehouses,  !empty($default_warehouse) ? $default_warehouse : '', ['class' => 'tcb-select form-control']) }}
            </div>
            {!! Form::hidden('id', $id) !!}
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