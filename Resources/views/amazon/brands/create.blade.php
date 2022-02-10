@extends('tcb-amazon-sync::layouts.tcbmaster')

@section('title', "Brands")

@push('css')

@endpush

@section('new_button')
@endsection

@section('content')

<form method="POST" action="{{route('tcb-amazon-sync.amazon.brand.save')}}" files="true" accept-charset="UTF-8" id="createBrand"  @submit.prevent="onSubmit" role="form" novalidate="" enctype="multipart/form-data">
@csrf
<div class="card">
    <div class="card-header tcb-card-header">{{ trans('tcb-amazon-sync::general.create') }} {{ trans('tcb-amazon-sync::brand.brand') }}</div>

    <div class="card-body">
        <div class="row mt-3">

            {{ Form::textGroup('name', trans('tcb-amazon-sync::brand.name'), 'fas fa-file-signature', [], '', 'col-md-4') }}

            <div class="form-group col-md-4">
                <p class="form-control-label">{{trans('tcb-amazon-sync::brand.enabled')}}</p>
                <label class="custom-toggle">
                    <input name ="enabled" class="tcb-switch" type="checkbox" value="">
                    <span class="custom-toggle-slider rounded-circle" data-label-off="No" data-label-on="Yes"></span>
                </label>
            </div>

            <div class="form-group col-md-4">
                <p>{{trans('tcb-amazon-sync::brand.defaultBrand')}}</p>
                <label class="custom-toggle">
                    <input name ="default_brand" class="tcb-switch" type="checkbox" value="">
                    <span class="custom-toggle-slider rounded-circle" data-label-off="No" data-label-on="Yes"></span>
                </label>
            </div>

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