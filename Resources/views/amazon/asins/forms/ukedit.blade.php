@php

    if (! $amz_item || empty($amz_item)) {
        $ean = 'null';
    } else {
        $ean = $amz_item->ean;
    }
@endphp
{!! Form::model($uk_item, [
    'method' => 'POST',
    'route' => ['tcb-amazon-sync.items.update'],
    'id' => 'ukAmazonItem',
    '@submit.prevent' => 'onSubmit',
    'role' => 'form',
    'novalidate' => true,
    'files' => true,
    'enctype' => 'multipart/form-data',
]) !!}

<div id="ukAsin" class="tab-pane fade show active">
    {!! Form::hidden('inv_item_id', $inventory_item->id) !!}
    {!! Form::hidden('id', $uk_item->id) !!}
    {!! Form::hidden('country', 'Uk') !!}
    <div class="row mt-3">
        <div class="col-md-12 mb-3 bg-secondary p-2 text-center">
            <input name="enable" type="checkbox" value="{{ !empty($uk_item->enable) ? $uk_item->enable : 0 }}" checked="{{ !empty($uk_item->enable) ? 'checked' : '' }}" class="tcb-checkbox">
            <label class="tcb-inlineblock tcb-checkbox-label" for="enable">{{ trans('tcb-amazon-sync::items.amazon.enable.uk') }}</label>
        </div>
        {{ Form::textGroup('ean', trans('tcb-amazon-sync::items.ean'), 'fa fa-key', [], !empty($uk_item->ean) ? $uk_item->ean : '', 'col-md-6') }}
            
        {{ Form::textGroup('sku', trans('tcb-amazon-sync::items.sku'), 'money-bill-wave-alt', [], !empty($uk_item->sku) ? $uk_item->sku : '', 'col-md-6') }}
            
        {{ Form::textGroup('asin', trans('tcb-amazon-sync::items.asin'), 'money-bill-wave-alt', [], !empty($uk_item->asin) ? $uk_item->asin : '', 'col-md-6') }}
            
        {{ Form::textGroup('brand', trans('tcb-amazon-sync::items.brand'), 'money-bill-wave-alt', [], !empty($uk_item->brand) ? $uk_item->brand : '', 'col-md-6') }}
            
        {{ Form::textGroup('size', trans('tcb-amazon-sync::items.color'), 'money-bill-wave-alt', [], !empty($uk_item->color) ? $uk_item->color : '', 'col-md-6') }}
            
        {{ Form::textGroup('color', trans('tcb-amazon-sync::items.size'), 'money-bill-wave-alt', [], !empty($uk_item->size) ? $uk_item->size : '', 'col-md-6') }}
            
        {{ Form::textGroup('material', trans('tcb-amazon-sync::items.material'), 'money-bill-wave-alt', [], !empty($uk_item->material) ? $uk_item->material : '', 'col-md-6') }}

        {{ Form::textGroup('price', trans('tcb-amazon-sync::items.price'), 'money-bill-wave-alt', [], !empty($uk_item->price) ? $uk_item->price : '', 'col-md-6') }}

        {{ Form::textGroup('sale_price', trans('tcb-amazon-sync::items.sale_price'), 'money-bill-wave-alt', [], !empty($uk_item->sale_price) ? $uk_item->sale_price : '', 'col-md-6') }}
        
        <div class="form-group col-md-6">
            <label class="datelabel form-control-label" for="sale_start_date">{{ trans('tcb-amazon-sync::items.sale_start_date') }}</label>
            <div class="input-group input-group-merge ">
            <input type="text" class="form-control datepicker" name="sale_start_date" placeholder="Enter {{ trans('tcb-amazon-sync::items.sale_start_date') }}">
            </div>
        </div>
        
        <div class="form-group col-md-6">
            <label class="datelabel form-control-label" for="sale_end_date">{{ trans('tcb-amazon-sync::items.sale_end_date') }}</label>
            <div class="input-group input-group-merge ">
            <input type="text" class="form-control datepicker" name="sale_end_date" placeholder="Enter {{ trans('tcb-amazon-sync::items.sale_end_date') }}">
            </div>
        </div>

        {{ Form::textGroup('quantity', trans('tcb-amazon-sync::items.quantity'), '', [], !empty($uk_item->quantity) ? $uk_item->quantity : '', 'col-md-6') }}

        {{ Form::textGroup('title', trans('tcb-amazon-sync::items.title'), '', [], !empty($uk_item->title) ? $uk_item->title : '', 'col-md-12') }}

        <p class="col-md-3 tcb-helptext p-3">Find your category at <a href="{{ route('tcb-amazon-sync.amazon.categories') }}" target="_blank">Amazon Categories List</a>, and enter UK Node ID value</p>
        {{ Form::textGroup('category', trans('tcb-amazon-sync::items.category'), '', ['help' => 'Help Text'], !empty($uk_item->category) ? $uk_item->category : '', 'col-md-9') }}

        {{ Form::textGroup('bullet_point_1', trans('tcb-amazon-sync::items.bullet_point_1'), '', [], !empty($uk_item->bullet_point_1) ? $uk_item->bullet_point_1 : '', 'col-md-6') }}

        {{ Form::textGroup('bullet_point_2', trans('tcb-amazon-sync::items.bullet_point_2'), '', [], !empty($uk_item->bullet_point_2) ? $uk_item->bullet_point_2 : '', 'col-md-6') }}

        {{ Form::textGroup('bullet_point_3', trans('tcb-amazon-sync::items.bullet_point_3'), '', [], !empty($uk_item->bullet_point_3) ? $uk_item->bullet_point_3 : '', 'col-md-6') }}

        {{ Form::textGroup('bullet_point_4', trans('tcb-amazon-sync::items.bullet_point_4'), '', [], !empty($uk_item->bullet_point_4) ? $uk_item->bullet_point_4 : '', 'col-md-6') }}

        {{ Form::textGroup('bullet_point_5', trans('tcb-amazon-sync::items.bullet_point_5'), '', [], !empty($uk_item->bullet_point_5) ? $uk_item->bullet_point_5 : '', 'col-md-6') }}

        {{ Form::textGroup('bullet_point_6', trans('tcb-amazon-sync::items.bullet_point_6'), '', [], !empty($uk_item->bullet_point_6) ? $uk_item->bullet_point_6 : '', 'col-md-6') }}

        {{ Form::textareaGroup('description', trans('tcb-amazon-sync::items.description'), [], !empty($uk_item->description) ? $uk_item->description : '') }}

        <div class="form-group col-md-6" id="mainPicture">
            <label class="" for="enable">{{ trans('tcb-amazon-sync::items.images.mainpic') }}</label>
            <input id="mainPic" type="file" name="main_picture" accept=".jpg, .png, image/jpeg, image/png" data-image="{{ !empty($uk_item->main_picture) ? asset('public/'. $uk_item->main_picture) : '' }}">
        </div>
        
        <div class="form-group col-md-4" id="picture_1">
            <label class="" for="enable">{{ trans('tcb-amazon-sync::items.images.pic1') }}</label>
            <input id="pic1" type="file" name="picture_1" accept=".jpg, .png, image/jpeg, image/png" data-image="{{ !empty($uk_item->picture_1) ? asset('public/'. $uk_item->picture_1) : '' }}">
        </div>
        
        <div class="form-group col-md-4" id="picture_2">
            <label class="" for="enable">{{ trans('tcb-amazon-sync::items.images.pic2') }}</label>
            <input id="pic2" type="file" name="picture_2" accept=".jpg, .png, image/jpeg, image/png" data-image="{{ !empty($uk_item->picture_2) ? asset('public/'. $uk_item->picture_2) : '' }}">
        </div>

        <div class="form-group col-md-4" id="picture_3">
            <label class="" for="enable">{{ trans('tcb-amazon-sync::items.images.pic3') }}</label>
            <input id="pic3" type="file" name="picture_3" accept=".jpg, .png, image/jpeg, image/png" data-image="{{ !empty($uk_item->picture_3) ? asset('public/'. $uk_item->picture_3) : '' }}">
        </div>

        <div class="form-group col-md-4" id="picture_4">
            <label class="" for="enable">{{ trans('tcb-amazon-sync::items.images.pic4') }}</label>
            <input id="pic4" type="file" name="picture_4" accept=".jpg, .png, image/jpeg, image/png" data-image="{{ !empty($uk_item->picture_4) ? asset('public/'. $uk_item->picture_4) : '' }}">
        </div>

        <div class="form-group col-md-4" id="picture_5">
            <label class="" for="enable">{{ trans('tcb-amazon-sync::items.images.pic5') }}</label>
            <input id="pic5" type="file" name="picture_5" accept=".jpg, .png, image/jpeg, image/png" data-image="{{ !empty($uk_item->picture_4) ? asset('public/'. $uk_item->picture_5) : '' }}">
        </div>

        <div class="form-group col-md-4" id="picture_6">
            <label class="" for="enable">{{ trans('tcb-amazon-sync::items.images.pic6') }}</label>
            <input id="pic6" type="file" name="picture_6" accept=".jpg, .png, image/jpeg, image/png" data-image="{{ !empty($uk_item->picture_6) ? asset('public/'. $uk_item->picture_6) : '' }}">
        </div>
    </div>
</div>
{!! Form::close() !!}

<div class="row save-buttons col-md-12">
    <div class="col-md-1">
        <button data-url="{{route('tcb-amazon-sync.items.update')}}" id="saveAmazonItem" class="btn btn-lg btn-icon btn-success">
            <span class="btn-inner--text">{{ trans('tcb-amazon-sync::items.amazon.save') }}</span>
        </button>
    </div>
    <div class="col-md-4">
        <button id="fetchAmazonItem" class="btn btn-lg btn-icon btn-info" data-url="{{ route('tcb-amazon-sync.amazon.item.fetch', ['item_id' => $item->id, 'inv_item_id' => $inventory_item->id, 'sku' => $inventory_item->sku, 'ean' => $uk_item->ean, 'country' => 'Uk']) }}">
            <span class="btn-inner--text">{{ trans('tcb-amazon-sync::items.amazon.fetch') }}</span>
        </button>
    </div>
    <div class="col-md-7">
        <div id="successMsg" class="alert alert-info" style="display: none">
            <span class="alert-icon"><i class="ni ni-like-2"></i></span>
            <span class="alert-text"><strong>SUCCESS!</strong> Data successfully saved. </span>
        </div>
        <div id="successMsgAmazon" class="alert alert-danger" style="display: none">
            <span class="alert-icon"><i class="ni ni-like-2"></i></span>
            <span class="alert-text"><strong>SUCCESS!</strong> Data successfully fetched from Amazon.co.uk. </span>
        </div>
    </div>
</div>