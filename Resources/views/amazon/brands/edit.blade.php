@extends('tcb-amazon-sync::layouts.tcbmaster')

@section('title', "Brands")

@push('css')

@endpush

@section('new_button')
<a href="{{ route('tcb-amazon-sync.amazon.brands.create') }}" class="btn btn-primary btn-sm"><i class="fas fa-plus-square"></i> {{ trans('tcb-amazon-sync::general.create') }} {{ trans('tcb-amazon-sync::brand.brand') }}</a>
<a href="{{ route('tcb-amazon-sync.amazon.brand.destroy', ['id' => $brand->id]) }}" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i> {{ trans('tcb-amazon-sync::general.destroy') }} {{ $brand->name }}</a>
<a href="{{ route('tcb-amazon-sync.amazon.brand.duplicate', ['id' => $brand->id]) }}" class="btn btn-info btn-sm"><i class="fas fa-clone"></i> {{ trans('tcb-amazon-sync::general.duplicate') }} {{ $brand->name }}</a>
@endsection

@section('content')
<form id="brandForm" method="POST" accept-charset="UTF-8" id="editBrand"novalidate="" enctype="multipart/form-data">
    @csrf

<div class="card bg-default text-white">
    <div class="card-header bg-transparent tcb-card-header">{{ trans('tcb-amazon-sync::brand.editing') }} "{{ $brand->name }}" {{ trans('tcb-amazon-sync::brand.brand') }}</div>

    <div class="card-body">
        <div class="row mt-3">

            {{ Form::textGroup('name', trans('tcb-amazon-sync::brand.name'), 'fas fa-file-signature', [], !empty($brand->name) ? $brand->name : '', 'col-md-4 text-white') }}
            <div class="form-group col-md-4">
                <p class="form-control-label text-white">{{trans('tcb-amazon-sync::brand.enabled')}}</p>
                <label class="custom-toggle">
                    <input name ="enabled" class="tcb-switch" type="checkbox" {{!empty($brand->enabled) ? 'checked' : ''}} value="{{ $brand->enabled }}">
                    <span class="custom-toggle-slider rounded-circle" data-label-off="No" data-label-on="Yes"></span>
                </label>
            </div>

            <div class="form-group col-md-4">
                <p>{{trans('tcb-amazon-sync::brand.defaultBrand')}}</p>
                <label class="custom-toggle">
                    <input name ="default_brand" class="tcb-switch" type="checkbox" {{!empty($brand->default_brand) ? 'checked' : ''}} value="{{ $brand->default_brand }}">
                    <span class="custom-toggle-slider rounded-circle" data-label-off="No" data-label-on="Yes"></span>
                </label>
            </div>

        </div>
    </div>
        
    <div class="card-footer bg-transparent ">
        <div class="row save-buttons">
            <button id="brandFormButton" data-action="{{route('tcb-amazon-sync.amazon.brand.update', ['id' => $brand->id])}}" class="btn btn-icon btn-success"><span class="btn-inner--text">Save</span></button>
        </div>
        <div class="brandMessage text-white">

        </div>
    </div>
</div>
</form>

@stop