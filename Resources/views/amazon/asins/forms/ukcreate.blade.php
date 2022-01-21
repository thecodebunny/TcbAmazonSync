@php

    if (! $amz_item || empty($amz_item)) {
        $ean = 'null';
    } else {
        $ean = $amz_item->ean;
    }

@endphp
<div id="ukAsin" class="tab-pane fade show active">
    <form method="POST" action="{{route('tcb-amazon-sync.items.create')}}" files="true" accept-charset="UTF-8" id="ukAmazonItem"  @submit.prevent="onSubmit" role="form" novalidate="" enctype="multipart/form-data">
    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
    <input name="country" type="hidden" value="Uk" id="country" name="country">
    {!! Form::hidden('inv_item_id', $inventory_item->id) !!}
    <div class="row mt-3">
        <div class="col-md-12 mb-3 bg-secondary p-2 text-center">
            <input name="enable" type="checkbox" value="" class="tcb-checkbox">
            <label class="tcb-inlineblock tcb-checkbox-label" for="enable">{{ trans('tcb-amazon-sync::items.amazon.enable.uk') }}</label>
        </div>
        {{ Form::textGroup('ean', trans('tcb-amazon-sync::items.ean'), 'fa fa-key', [], !empty($amz_item->ean) ? $amz_item->ean : '', 'col-md-6') }}
            
        {{ Form::textGroup('sku', trans('tcb-amazon-sync::items.sku'), 'money-bill-wave-alt', [], !empty($inventory_item->sku) ? $inventory_item->sku : '', 'col-md-6') }}
            
        {{ Form::textGroup('asin', trans('tcb-amazon-sync::items.asin'), 'money-bill-wave-alt', [], '', 'col-md-6') }}
            
        {{ Form::textGroup('brand', trans('tcb-amazon-sync::items.brand'), 'money-bill-wave-alt', [], '', 'col-md-6') }}
            
        {{ Form::textGroup('size', trans('tcb-amazon-sync::items.size'), 'money-bill-wave-alt', [], !empty($uk_item->size) ? $uk_item->size : '', 'col-md-4') }}
            
        {{ Form::textGroup('height', trans('tcb-amazon-sync::items.height'), 'money-bill-wave-alt', [], !empty($uk_item->height) ? $uk_item->height : '', 'col-md-4') }}
            
        {{ Form::textGroup('length', trans('tcb-amazon-sync::items.length'), 'money-bill-wave-alt', [], !empty($uk_item->length) ? $uk_item->length : '', 'col-md-4') }}
            
        {{ Form::textGroup('weight', trans('tcb-amazon-sync::items.weight'), 'money-bill-wave-alt', [], !empty($uk_item->weight) ? $uk_item->weight : '', 'col-md-4') }}
            
        {{ Form::textGroup('width', trans('tcb-amazon-sync::items.width'), 'money-bill-wave-alt', [], !empty($uk_item->width) ? $uk_item->width : '', 'col-md-4') }}
            
        {{ Form::textGroup('color', trans('tcb-amazon-sync::items.color'), 'money-bill-wave-alt', [], !empty($uk_item->color) ? $uk_item->color : '', 'col-md-4') }}
            
        {{ Form::textGroup('material', trans('tcb-amazon-sync::items.material'), 'money-bill-wave-alt', [], !empty($uk_item->material) ? $uk_item->material : '', 'col-md-4') }}

        {{ Form::textGroup('price', trans('tcb-amazon-sync::items.price'), 'money-bill-wave-alt', [], !empty($uk_item->price) ? $uk_item->price : '', 'col-md-4') }}

        {{ Form::textGroup('sale_price', trans('tcb-amazon-sync::items.sale_price'), 'money-bill-wave-alt', [], !empty($uk_item->sale_price) ? $uk_item->sale_price : '', 'col-md-4') }}
        
        <div class="form-group col-md-4">
            <label class="datelabel form-control-label" for="sale_start_date">{{ trans('tcb-amazon-sync::items.sale_start_date') }}</label>
            <div class="input-group input-group-merge ">
            <input type="text" class="form-control datepicker" name="sale_start_date" placeholder="Enter {{ trans('tcb-amazon-sync::items.sale_start_date') }}">
            </div>
        </div>
        
        <div class="form-group col-md-4">
            <label class="datelabel form-control-label" for="sale_end_date">{{ trans('tcb-amazon-sync::items.sale_end_date') }}</label>
            <div class="input-group input-group-merge ">
            <input type="text" class="form-control datepicker" name="sale_end_date" placeholder="Enter {{ trans('tcb-amazon-sync::items.sale_end_date') }}">
            </div>
        </div>

        {{ Form::textGroup('quantity', trans('tcb-amazon-sync::items.quantity'), '', [], !empty($item->quantity) ? $item->quantity : '', 'col-md-4') }}

        {{ Form::textGroup('title', trans('tcb-amazon-sync::items.title'), '', [], !empty($item->name) ? $item->name : '', 'col-md-12') }}

        <p class="col-md-6 tcb-helptext p-3 text-center">Find your category at <a href="{{ route('tcb-amazon-sync.amazon.categories') }}" target="_blank">Amazon Categories List</a>, and enter UK Node ID value</p>
        {{ Form::textGroup('category_id', trans('tcb-amazon-sync::items.category_id'), '', ['help' => 'Help Text'], !empty($uk_item->category_id) ? $uk_item->category_id : '', 'col-md-6') }}

        {{ Form::textGroup('bullet_point_1', trans('tcb-amazon-sync::items.bullet_point_1'), '', [], !empty($uk_item->bullet_point_1) ? $uk_item->bullet_point_1 : '', 'col-md-6') }}

        {{ Form::textGroup('bullet_point_2', trans('tcb-amazon-sync::items.bullet_point_2'), '', [], !empty($uk_item->bullet_point_2) ? $uk_item->bullet_point_2 : '', 'col-md-6') }}

        {{ Form::textGroup('bullet_point_3', trans('tcb-amazon-sync::items.bullet_point_3'), '', [], !empty($uk_item->bullet_point_3) ? $uk_item->bullet_point_3 : '', 'col-md-6') }}

        {{ Form::textGroup('bullet_point_4', trans('tcb-amazon-sync::items.bullet_point_4'), '', [], !empty($uk_item->bullet_point_4) ? $uk_item->bullet_point_4 : '', 'col-md-6') }}

        {{ Form::textGroup('bullet_point_5', trans('tcb-amazon-sync::items.bullet_point_5'), '', [], !empty($uk_item->bullet_point_5) ? $uk_item->bullet_point_5 : '', 'col-md-6') }}

        {{ Form::textGroup('bullet_point_6', trans('tcb-amazon-sync::items.bullet_point_6'), '', [], !empty($uk_item->bullet_point_6) ? $uk_item->bullet_point_6 : '', 'col-md-6') }}

        {{ Form::textareaGroup('description', trans('tcb-amazon-sync::items.description'), [], !empty($uk_item->description) ? $uk_item->description : '') }}

        <div class="form-group col-md-6" id="mainPicture">
            <label class="" for="enable">{{ trans('tcb-amazon-sync::items.images.mainpic') }}</label>
            <input id="mainPic" type="file" name="main_picture" accept=".jpg, .png, image/jpeg, image/png" data-image="{{ !empty($uk_item->main_picture) ? asset('public/'. $uk_item->main_picture) : '' }}" value="{{ !empty($uk_item->main_picture) ? asset('public/'. $uk_item->main_picture) : '' }}">
        </div>

        <div class="col-md-6"></div>
        
        <div class="form-group col-md-4" id="picture_1">
            <label class="" for="enable">{{ trans('tcb-amazon-sync::items.images.pic1') }}</label>
            <input id="pic1" type="file" name="picture_1" accept=".jpg, .png, image/jpeg, image/png" data-image="{{ !empty($uk_item->picture_1) ? asset('public/'. $uk_item->picture_1) : '' }}" value="{{ !empty($uk_item->picture_1) ? asset('public/'. $uk_item->picture_1) : '' }}">
        </div>
        
        <div class="form-group col-md-4" id="picture_2">
            <label class="" for="enable">{{ trans('tcb-amazon-sync::items.images.pic2') }}</label>
            <input id="pic2" type="file" name="picture_2" accept=".jpg, .png, image/jpeg, image/png" data-image="{{ !empty($uk_item->picture_2) ? asset('public/'. $uk_item->picture_2) : '' }}" value="{{ !empty($uk_item->picture_2) ? asset('public/'. $uk_item->picture_2) : '' }}">
        </div>

        <div class="form-group col-md-4" id="picture_3">
            <label class="" for="enable">{{ trans('tcb-amazon-sync::items.images.pic3') }}</label>
            <input id="pic3" type="file" name="picture_3" accept=".jpg, .png, image/jpeg, image/png" data-image="{{ !empty($uk_item->picture_3) ? asset('public/'. $uk_item->picture_3) : '' }}" value="{{ !empty($uk_item->picture_3) ? asset('public/'. $uk_item->picture_3) : '' }}">
        </div>

        <div class="form-group col-md-4" id="picture_4">
            <label class="" for="enable">{{ trans('tcb-amazon-sync::items.images.pic4') }}</label>
            <input id="pic4" type="file" name="picture_4" accept=".jpg, .png, image/jpeg, image/png" data-image="{{ !empty($uk_item->picture_4) ? asset('public/'. $uk_item->picture_4) : '' }}" value="{{ !empty($uk_item->picture_4) ? asset('public/'. $uk_item->picture_4) : '' }}">
        </div>

        <div class="form-group col-md-4" id="picture_5">
            <label class="" for="enable">{{ trans('tcb-amazon-sync::items.images.pic5') }}</label>
            <input id="pic5" type="file" name="picture_5" accept=".jpg, .png, image/jpeg, image/png" data-image="{{ !empty($uk_item->picture_4) ? asset('public/'. $uk_item->picture_5) : '' }}" value="{{ !empty($uk_item->picture_5) ? asset('public/'. $uk_item->picture_5) : '' }}">
        </div>

        <div class="form-group col-md-4" id="picture_6">
            <label class="" for="enable">{{ trans('tcb-amazon-sync::items.images.pic6') }}</label>
            <input id="pic6" type="file" name="picture_6" accept=".jpg, .png, image/jpeg, image/png" data-image="{{ !empty($uk_item->picture_6) ? asset('public/'. $uk_item->picture_6) : '' }}" value="{{ !empty($uk_item->picture_6) ? asset('public/'. $uk_item->picture_6) : '' }}">
        </div>
    </div>

    {!! Form::close() !!}

    <div class="row save-buttons col-md-12">
        <div class="col-md-1">
            <button id="saveAmazonItem" class="btn btn-lg btn-icon btn-success">
                <span class="btn-inner--text">{{ trans('tcb-amazon-sync::items.amazon.save') }}</span>
            </button>
        </div>
        <div class="col-md-4">
            <button id="fetchAmazonItem" class="btn btn-lg btn-icon btn-info" data-url="{{ route('tcb-amazon-sync.amazon.item.fetch', ['item_id' => $item->id, 'inv_item_id' => $inventory_item->id, 'sku' => $sku, 'ean' => $ean, 'country' => 'Uk']) }}">
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
</div>