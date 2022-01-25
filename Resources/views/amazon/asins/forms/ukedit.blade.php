
<div class="card pl-3 pr-3">
{!! Form::model($amzItem, [
    'method' => 'POST',
    'route' => ['tcb-amazon-sync.items.update', 'id' => $amzItem->id],
    'id' => 'ukAmazonItem',
    '@submit.prevent' => 'onSubmit',
    'role' => 'form',
    'novalidate' => true,
    'files' => true,
    'enctype' => 'multipart/form-data',
]) !!}
<div id="ukAsin" class="tab-pane fade show active">
    {!! Form::hidden('item_id', $item->id) !!}
    {!! Form::hidden('id', $amzItem->id) !!}
    {!! Form::hidden('country', 'Uk') !!}
    <div class="row">
        <div class="col-md-12 mb-3 bg-warning text-white p-2 text-center">
            @empty($amzItem) @if($amzItem->otherseller_warning) <a style="background: rgb(158, 1, 1); color: white; padding: 5px"><span class="fa fa-bug"> </span>   THERE IS OTHER SELLER ON AMAZON UK   </a>@endif @endempty
            <input name="enable" type="checkbox" value="{{ !empty($amzItem->enable) ? $amzItem->enable : 0 }}" checked="{{ !empty($amzItem->enable) ? 'checked' : '' }}" class="tcb-checkbox">
            <label class="tcb-inlineblock tcb-checkbox-label" for="enable">{{ trans('tcb-amazon-sync::items.amazon.enable.uk') }}</label>
        </div>

        {{ Form::textGroup('title', trans('tcb-amazon-sync::items.title'), '', [], !empty($amzItem->title) ? $amzItem->title : '', 'col-md-12') }}

        {{ Form::textGroup('quantity', trans('tcb-amazon-sync::items.quantity'), '', [], !empty($amzItem->quantity) ? $amzItem->quantity : '', 'col-md-3') }}

        {{ Form::textGroup('ean', trans('tcb-amazon-sync::items.ean'), 'fab fa-umbraco', [], !empty($amzItem->ean) ? $amzItem->ean : '', 'col-md-3') }}
            
        {{ Form::textGroup('sku', trans('tcb-amazon-sync::items.sku'), 'fas fa-passport', [], !empty($amzItem->sku) ? $amzItem->sku : '', 'col-md-3') }}


        <div class="form-group col-md-3">
            <label for="warehouse" class="form-control-label">{{ trans('tcb-amazon-sync::warehouse.warehouse') }}</label>
            <select name="warehouse" class="form-control tcb-select">
                @foreach ($warehouses as $warehouse)
                    <option value="{{$warehouse->id}}" @if($amzItem->warehouse == $warehouse->id) selected @endif>{{ $warehouse->name }}</option>
                @endforeach
            </select>
        </div>
            
        {{ Form::textGroup('asin', trans('tcb-amazon-sync::items.asin'), 'fab fa-amazon', [], !empty($amzItem->asin) ? $amzItem->asin : '', 'col-md-3') }}
            
        {{ Form::textGroup('brand', trans('tcb-amazon-sync::items.brand'), 'fas fa-copyright', [], !empty($amzItem->brand) ? $amzItem->brand : '', 'col-md-3') }}
            
        {{ Form::textGroup('size', trans('tcb-amazon-sync::items.size'), 'fas fa-window-maximize', [], !empty($amzItem->size) ? $amzItem->size : '', 'col-md-3') }}
            
        {{ Form::textGroup('height', trans('tcb-amazon-sync::items.height'), 'fas fa-ruler-vertical', [], !empty($amzItem->height) ? $amzItem->height : '', 'col-md-3') }}
            
        {{ Form::textGroup('length', trans('tcb-amazon-sync::items.length'), 'fas fa-ruler', [], !empty($amzItem->length) ? $amzItem->length : '', 'col-md-4') }}
            
        {{ Form::textGroup('width', trans('tcb-amazon-sync::items.width'), 'fas fa-ruler-horizontal', [], !empty($amzItem->width) ? $amzItem->width : '', 'col-md-4') }}
            
        {{ Form::textGroup('weight', trans('tcb-amazon-sync::items.weight'), 'fas fa-weight-hanging', [], !empty($amzItem->weight) ? $amzItem->weight : '', 'col-md-4') }}
            
        {{ Form::textGroup('color', trans('tcb-amazon-sync::items.color'), 'fas fa-tint', [], !empty($amzItem->color) ? $amzItem->color : '', 'col-md-4') }}
            
        {{ Form::textGroup('material', trans('tcb-amazon-sync::items.material'), 'fas fa-cubes', [], !empty($amzItem->material) ? $amzItem->material : '', 'col-md-4') }}

        {{ Form::textGroup('price', trans('tcb-amazon-sync::items.price'), 'fas fa-tags', [], !empty($amzItem->price) ? $amzItem->price : '', 'col-md-4') }}

        {{ Form::textGroup('lead_time_to_ship_max_days', trans('tcb-amazon-sync::items.shipmaxdays'), '', [], !empty($amzItem->lead_time_to_ship_max_days) ? $amzItem->lead_time_to_ship_max_days : '', 'col-md-4') }}

        {{ Form::textGroup('country_of_origin', trans('tcb-amazon-sync::items.countryorigin'), '', [], !empty($amzItem->country_of_origin) ? $amzItem->country_of_origin : '', 'col-md-4') }}

        {{ Form::textGroup('sale_price', trans('tcb-amazon-sync::items.sale_price'), 'fas fa-bookmark', [], !empty($amzItem->sale_price) ? $amzItem->sale_price : '', 'col-md-4') }}
        
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

        <p class="col-md-8 tcb-helptext p-3">Find your category at <a href="{{ route('tcb-amazon-sync.amazon.categories') }}" target="_blank">Amazon Categories List</a>, and enter UK Node ID value</br>
        <a style="font-weight: bold; font-size: 14px">Selected: <span style="color: rgb(175, 2, 2)">{{ !empty($uk_cat_name) ? $uk_cat_name : '' }}</span></a></p>
        {{ Form::textGroup('category_id', trans('tcb-amazon-sync::items.category'), '', ['help' => 'Help Text'], !empty($amzItem->category_id) ? $amzItem->category_id : '', 'col-md-4') }}

        {{ Form::textGroup('bullet_point_1', trans('tcb-amazon-sync::items.bullet_point_1'), '', [], !empty($amzItem->bullet_point_1) ? $amzItem->bullet_point_1 : '', 'col-md-6') }}

        {{ Form::textGroup('bullet_point_2', trans('tcb-amazon-sync::items.bullet_point_2'), '', [], !empty($amzItem->bullet_point_2) ? $amzItem->bullet_point_2 : '', 'col-md-6') }}

        {{ Form::textGroup('bullet_point_3', trans('tcb-amazon-sync::items.bullet_point_3'), '', [], !empty($amzItem->bullet_point_3) ? $amzItem->bullet_point_3 : '', 'col-md-6') }}

        {{ Form::textGroup('bullet_point_4', trans('tcb-amazon-sync::items.bullet_point_4'), '', [], !empty($amzItem->bullet_point_4) ? $amzItem->bullet_point_4 : '', 'col-md-6') }}

        {{ Form::textGroup('bullet_point_5', trans('tcb-amazon-sync::items.bullet_point_5'), '', [], !empty($amzItem->bullet_point_5) ? $amzItem->bullet_point_5 : '', 'col-md-6') }}

        {{ Form::textGroup('bullet_point_6', trans('tcb-amazon-sync::items.bullet_point_6'), '', [], !empty($amzItem->bullet_point_6) ? $amzItem->bullet_point_6 : '', 'col-md-6') }}

        {{ Form::textareaGroup('description', trans('tcb-amazon-sync::items.description'), [], !empty($amzItem->description) ? $amzItem->description : '') }}

        {{ Form::textareaGroup('keywords', trans('tcb-amazon-sync::items.keywords'), [], !empty($amzItem->keywords) ? $amzItem->keywords : '') }}

        <div class="form-group col-md-6" id="mainPicture">
            <label class="" for="enable">{{ trans('tcb-amazon-sync::items.images.mainpic') }}</label>
            <input id="mainPic" type="file" name="main_picture" accept=".jpg, .png, image/jpeg, image/png" data-image="{{ !empty($amzItem->main_picture) ? asset('public/'. $amzItem->main_picture) : '' }}">
        </div>
        <div class="form-group col-md-6" id="">
        </div>

        <div class="form-group col-md-4" id="picture_1">
            <label class="" for="enable">{{ trans('tcb-amazon-sync::items.images.pic1') }}</label>
            <input id="pic1" type="file" name="picture_1" accept=".jpg, .png, image/jpeg, image/png" data-image="{{ !empty($amzItem->picture_1) ? asset('public/'. $amzItem->picture_1) : '' }}">
        </div>
        
        <div class="form-group col-md-4" id="picture_2">
            <label class="" for="enable">{{ trans('tcb-amazon-sync::items.images.pic2') }}</label>
            <input id="pic2" type="file" name="picture_2" accept=".jpg, .png, image/jpeg, image/png" data-image="{{ !empty($amzItem->picture_2) ? asset('public/'. $amzItem->picture_2) : '' }}">
        </div>

        <div class="form-group col-md-4" id="picture_3">
            <label class="" for="enable">{{ trans('tcb-amazon-sync::items.images.pic3') }}</label>
            <input id="pic3" type="file" name="picture_3" accept=".jpg, .png, image/jpeg, image/png" data-image="{{ !empty($amzItem->picture_3) ? asset('public/'. $amzItem->picture_3) : '' }}">
        </div>

        <div class="form-group col-md-4" id="picture_4">
            <label class="" for="enable">{{ trans('tcb-amazon-sync::items.images.pic4') }}</label>
            <input id="pic4" type="file" name="picture_4" accept=".jpg, .png, image/jpeg, image/png" data-image="{{ !empty($amzItem->picture_4) ? asset('public/'. $amzItem->picture_4) : '' }}">
        </div>

        <div class="form-group col-md-4" id="picture_5">
            <label class="" for="enable">{{ trans('tcb-amazon-sync::items.images.pic5') }}</label>
            <input id="pic5" type="file" name="picture_5" accept=".jpg, .png, image/jpeg, image/png" data-image="{{ !empty($amzItem->picture_4) ? asset('public/'. $amzItem->picture_5) : '' }}">
        </div>

        <div class="form-group col-md-4" id="picture_6">
            <label class="" for="enable">{{ trans('tcb-amazon-sync::items.images.pic6') }}</label>
            <input id="pic6" type="file" name="picture_6" accept=".jpg, .png, image/jpeg, image/png" data-image="{{ !empty($amzItem->picture_6) ? asset('public/'. $amzItem->picture_6) : '' }}">
        </div>
    </div>
</div>
{!! Form::close() !!}
<div class="card-footer">
<div class="row save-buttons col-md-12">
    <div class="col-md-1">
        <button data-url="{{route('tcb-amazon-sync.items.update', ['id' => $amzItem->id])}}" id="saveAmazonItem" class="btn btn-lg btn-icon btn-success">
            <span class="btn-inner--text">{{ trans('tcb-amazon-sync::items.amazon.save') }}</span>
        </button>
    </div>
    <div class="col-md-4">
        <button id="fetchAmazonItem" class="btn btn-lg btn-icon btn-info" data-url="{{ route('tcb-amazon-sync.amazon.item.fetch', ['item_id' => $item->id, 'ean' => $amzItem->ean, 'country' => 'Uk']) }}">
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
</div>