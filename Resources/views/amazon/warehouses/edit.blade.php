@extends('tcb-amazon-sync::layouts.tcbmaster')

@section('title', "Warehouses")

@push('css')

@endpush

@section('new_button')
<a href="{{ route('tcb-amazon-sync.amazon.warehouses.create') }}" class="btn btn-primary btn-sm"><i class="fas fa-plus-square"></i> {{ trans('tcb-amazon-sync::general.create') }} {{ trans('tcb-amazon-sync::warehouse.warehouse') }}</a>
<a href="{{ route('tcb-amazon-sync.amazon.warehouse.destroy', ['id' => $warehouse->id]) }}" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i> {{ trans('tcb-amazon-sync::general.destroy') }} {{ $warehouse->name }}</a>
<a href="{{ route('tcb-amazon-sync.amazon.warehouse.duplicate', ['id' => $warehouse->id]) }}" class="btn btn-info btn-sm"><i class="fas fa-clone"></i> {{ trans('tcb-amazon-sync::general.duplicate') }} {{ $warehouse->name }}</a>
@endsection

@section('content')
<form method="POST" action="{{route('tcb-amazon-sync.amazon.warehouse.update', ['id' => $warehouse->id])}}" accept-charset="UTF-8" id="editWarehouse"novalidate="" enctype="multipart/form-data">
    @csrf

<div class="card bg-default">
    <div class="card-header bg-transparent tcb-card-header">{{ trans('tcb-amazon-sync::warehouse.editing') }} "{{ $warehouse->name }}" {{ trans('tcb-amazon-sync::warehouse.warehouse') }}</div>

    <div class="card-body">
        <div class="row mt-3">

            {{ Form::textGroup('name', trans('tcb-amazon-sync::warehouse.name'), 'fas fa-file-signature', [], !empty($warehouse->name) ? $warehouse->name : '', 'col-md-6') }}
            <div class="form-group col-md-6">
                <p class="form-control-label">{{trans('tcb-amazon-sync::warehouse.enabled')}}</p>
                <label class="custom-toggle">
                    <input name ="enabled" class="tcb-switch" type="checkbox" {{!empty($warehouse->enabled) ? 'checked' : ''}} value="{{ $warehouse->enabled }}">
                    <span class="custom-toggle-slider rounded-circle" data-label-off="No" data-label-on="Yes"></span>
                </label>
            </div>

            <div class="form-group col-md-6">
                <p>{{trans('tcb-amazon-sync::warehouse.defaultWarehouse')}}</p>
                <label class="custom-toggle">
                    <input name ="default_warehouse" class="tcb-switch" type="checkbox" {{!empty($warehouse->default_warehouse) ? 'checked' : ''}} value="{{ $warehouse->default_warehouse }}">
                    <span class="custom-toggle-slider rounded-circle" data-label-off="No" data-label-on="Yes"></span>
                </label>
            </div>

            {{ Form::textGroup('street_1', trans('tcb-amazon-sync::warehouse.street_1'), 'fas fa-street-view', [], !empty($warehouse->street_1) ? $warehouse->street_1 : '', 'col-md-6') }}

            {{ Form::textGroup('street_2', trans('tcb-amazon-sync::warehouse.street_2'), 'fas fa-street-view', [], !empty($warehouse->street_2) ? $warehouse->street_2 : '', 'col-md-6') }}

            {{ Form::textGroup('postcode', trans('tcb-amazon-sync::warehouse.postcode'), 'fas fa-map-marker-alt', [], !empty($warehouse->postcode) ? $warehouse->postcode : '', 'col-md-6') }}

            {{ Form::textGroup('city', trans('tcb-amazon-sync::warehouse.city'), 'fas fa-city', [], !empty($warehouse->city) ? $warehouse->city : '', 'col-md-6') }}

            {{ Form::textGroup('country', trans('tcb-amazon-sync::warehouse.country'), 'fas fa-flag', [], !empty($warehouse->country) ? $warehouse->country : '', 'col-md-6') }}

        </div>
    </div>
        
    <div class="card-footer bg-transparent ">
        <div class="row save-buttons">
            <button type="submit" class="btn btn-icon btn-success"><span class="btn-inner--text">Save</span></button>
        </div>
    </div>
</div>
</form>

@stop