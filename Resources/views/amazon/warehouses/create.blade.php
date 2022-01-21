@extends('tcb-amazon-sync::layouts.tcbmaster')

@section('title', "Warehouses")

@push('css')

@endpush

@section('new_button')
@endsection

@section('content')

<form method="POST" action="{{route('tcb-amazon-sync.amazon.warehouse.save')}}" files="true" accept-charset="UTF-8" id="createWarehouse"  @submit.prevent="onSubmit" role="form" novalidate="" enctype="multipart/form-data">
@csrf
<div class="card">
    <div class="card-header tcb-card-header">{{ trans('tcb-amazon-sync::general.create') }} {{ trans('tcb-amazon-sync::warehouse.warehouse') }}</div>

    <div class="card-body">
        <div class="row mt-3">

            {{ Form::textGroup('name', trans('tcb-amazon-sync::warehouse.name'), 'fas fa-file-signature', [], '', 'col-md-6') }}

            <div class="form-group col-md-6">
                <p class="form-control-label">{{trans('tcb-amazon-sync::warehouse.enabled')}}</p>
                <label class="custom-toggle">
                    <input name ="enabled" class="tcb-switch" type="checkbox" value="">
                    <span class="custom-toggle-slider rounded-circle" data-label-off="No" data-label-on="Yes"></span>
                </label>
            </div>

            <div class="form-group col-md-6">
                <p>{{trans('tcb-amazon-sync::warehouse.defaultWarehouse')}}</p>
                <label class="custom-toggle">
                    <input name ="default_warehouse" class="tcb-switch" type="checkbox" value="">
                    <span class="custom-toggle-slider rounded-circle" data-label-off="No" data-label-on="Yes"></span>
                </label>
            </div>

            {{ Form::textGroup('street_1', trans('tcb-amazon-sync::warehouse.street_1'), 'fas fa-street-view', [], '', 'col-md-6') }}

            {{ Form::textGroup('street_2', trans('tcb-amazon-sync::warehouse.street_2'), 'fas fa-street-view', [], '', 'col-md-6') }}

            {{ Form::textGroup('postcode', trans('tcb-amazon-sync::warehouse.postcode'), 'fas fa-map-marker-alt', [], '', 'col-md-6') }}

            {{ Form::textGroup('city', trans('tcb-amazon-sync::warehouse.city'), 'fas fa-city', [], '', 'col-md-6') }}

            {{ Form::textGroup('country', trans('tcb-amazon-sync::warehouse.country'), 'fas fa-flag', [], '', 'col-md-6') }}

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