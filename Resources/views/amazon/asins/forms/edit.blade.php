@php
    $amzItem = $amzItems[$country]['item'];
    $catName = $amzItems[$country]['cat_name'];
    if ($amzItem->quantity == 0 || empty($amzItem->quantity)) {
        $qty = 0;
    } else {
        $qty = $amzItem->quantity;
    }
@endphp
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
        {!! Form::hidden('company_id', $amzItem->company_id) !!}
        {!! Form::hidden('country', 'Uk') !!}
        <div class="row">
            <div class="col-md-12 mb-3 bg-warning text-white text-center pt-2 pb-2">
                @if($amzItem->otherseller_warning) <a style="background: rgb(158, 1, 1); color: white; padding: 5px"><span class="fa fa-bug"> </span>   THERE IS OTHER SELLER ON AMAZON UK   </a>@endif
                <input name="enable" type="checkbox" value="{{ !empty($amzItem->enable) ? $amzItem->enable : 0 }}" checked="{{ !empty($amzItem->enable) ? 'checked' : '' }}" class="tcb-checkbox">
                <label class="tcb-inlineblock tcb-checkbox-label" for="enable">{{ trans('tcb-amazon-sync::items.amazon.enable.uk') }}</label>
                <br>{{ trans('tcb-amazon-sync::items.refreshwarning') }}
            </div>

            <div class="col-md-9">
                <a id="updateAmazonTitle" title="Update title on Amazon" class="tcb-tip bg-warning text-white p-1"><i class="fas fa-sync-alt"></i></a>
                {{ Form::textGroup('title', trans('tcb-amazon-sync::items.title'), 'fas fa-heading', [], !empty($amzItem->title) ? $amzItem->title : '', '') }}
            </div>

            <div class="col-md-3">
                <a id="updateAmazonStock" title="Update Stock on Amazon" class="tcb-tip bg-warning text-white p-1 updateAmazonStock"><i class="fas fa-sync-alt"></i></a>
                {{ Form::numberGroup('quantity', trans('tcb-amazon-sync::items.quantity'), 'fas fa-sort-numeric-down-alt', [], $qty, '') }}
            </div>

            {{ Form::textGroup('ean', trans('tcb-amazon-sync::items.ean'), 'fab fa-id-card', [], !empty($amzItem->ean) ? $amzItem->ean : '', 'col-md-3') }}
                
            {{ Form::textGroup('sku', trans('tcb-amazon-sync::items.sku'), 'fas fa-passport', [], !empty($amzItem->sku) ? $amzItem->sku : '', 'col-md-3') }}

            {{ Form::textGroup('packaging', trans('tcb-amazon-sync::items.packaging'), 'fas fa-boxes', [], !empty($amzItem->packaging) ? $amzItem->packaging : '', 'col-md-3') }}

            <div class="form-group col-md-3">
                <label for="warehouse" class="form-control-label">{{ trans('tcb-amazon-sync::warehouse.warehouse') }}</label>
                <select name="warehouse" class="form-control tcb-select">
                    <option class="el-select-dropdown__item" value="">{{ trans('tcb-amazon-sync::general.settings.select') }} Option</option>
                    @foreach ($warehouses as $warehouse)
                        <option value="{{$warehouse->id}}" @if($amzItem->warehouse == $warehouse->id) selected @endif>{{ $warehouse->name }}</option>
                    @endforeach
                </select>
            </div>
                
            {{ Form::textGroup('asin', trans('tcb-amazon-sync::items.asin'), 'fab fa-amazon', [], !empty($amzItem->asin) ? $amzItem->asin : '', 'col-md-3') }}
                
            <div class="form-group col-md-3">
                <label for="brand" class="form-control-label">{{ trans('tcb-amazon-sync::items.brand') }}</label>
                <select name="brand" class="form-control tcb-select">
                    <option class="el-select-dropdown__item" value="">{{ trans('tcb-amazon-sync::general.settings.select') }} Option</option>
                    @foreach ($brands as $brand)
                        <option value="{{$brand->name}}" @if($amzItem->brand == $brand->name) selected @elseif($brand->default_brand) selected @endif>{{ $brand->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group col-md-3">
                <a data-toggle="modal" data-target="#checkProductType" title="Check All Product Types" class="tcb-tip text-danger" style="font-size: 20px"><i class="fas fa-exclamation-circle"></i></a>
                {{ Form::textGroup('product_type', trans('tcb-amazon-sync::items.producttype'), 'fas fa-broom', ['required'], !empty($amzItem->product_type) ? $amzItem->product_type : '', '') }}
            </div>
                
            {{ Form::textGroup('size', trans('tcb-amazon-sync::items.size'), 'fas fa-window-maximize', [], !empty($amzItem->size) ? $amzItem->size : '', 'col-md-3') }}

            <div class="card-footer with-border col-md-12">
                <h3 class="card-title">{{ trans('tcb-amazon-sync::items.prices') }}</h3>
            </div>
        
            <div class="form-group col-md-3">
                <label for="currency_code" class="form-control-label">{{ trans('tcb-amazon-sync::items.currency') }}</label>
                <select name="currency_code" class="form-control tcb-select">
                    <option class="el-select-dropdown__item" value="">{{ trans('tcb-amazon-sync::general.settings.select') }} Option</option>
                    @foreach ($currencies as $currency)
                        <option value="{{$currency->code}}" @if($amzItem->currency_code == $currency->code) selected @elseif(setting('default.currency') == $currency->code) selected @endif>{{ $currency->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-3">
                <a id="updateAmazonPrice" title="Update title on Amazon" class="tcb-tip bg-warning text-white p-1"><i class="fas fa-sync-alt"></i></a>
                {{ Form::textGroup('price', trans('tcb-amazon-sync::items.price'), 'fas fa-tags', [], !empty($amzItem->price) ? $amzItem->price : '', '') }}
            </div>

            <div class="col-md-3">
                <a id="updateAmazonSalePrice" title="Update Sale Price on Amazon" class="tcb-tip bg-warning text-white p-1"><i class="fas fa-sync-alt"></i></a>
                {{ Form::textGroup('sale_price', trans('tcb-amazon-sync::items.sale_price'), 'fas fa-bookmark', [], !empty($amzItem->sale_price) ? $amzItem->sale_price : '', '') }}
            </div>
            
            <div class="form-group col-md-3">
                <label class="datelabel form-control-label" for="sale_start_date">{{ trans('tcb-amazon-sync::items.sale_start_date') }}</label>
                <div class="input-group input-group-merge ">
                <input type="text" class="form-control datepicker" name="sale_start_date" placeholder="Enter {{ trans('tcb-amazon-sync::items.sale_start_date') }}">
                </div>
            </div>
            
            <div class="form-group col-md-3">
                <label class="datelabel form-control-label" for="sale_end_date">{{ trans('tcb-amazon-sync::items.sale_end_date') }}</label>
                <div class="input-group input-group-merge ">
                <input type="text" class="form-control datepicker" name="sale_end_date" placeholder="Enter {{ trans('tcb-amazon-sync::items.sale_end_date') }}">
                </div>
            </div>

            <div class="card-footer with-border col-md-12">
                <h3 class="card-title">{{ trans('tcb-amazon-sync::items.attributes') }}</h3>
            </div>
                
            {{ Form::textGroup('height', trans('tcb-amazon-sync::items.height'), 'fas fa-ruler-vertical', [], !empty($amzItem->height) ? $amzItem->height : '', 'col-md-3') }}
        
            <div class="form-group col-md-3">
                <label for="height_measure" class="form-control-label">{{ trans('tcb-amazon-sync::items.heightmeasure') }}</label>
                <select name="height_measure" class="form-control tcb-select">
                    <option class="el-select-dropdown__item" value="">{{ trans('tcb-amazon-sync::general.settings.select') }} Option</option>
                    <option value="angstrom" @if($amzItem->height_measure == 'angstrom') selected @endif>{{ trans('tcb-amazon-sync::items.angstrom') }}</option>
                    <option value="mils" @if($amzItem->height_measure == 'mils') selected @endif>{{ trans('tcb-amazon-sync::items.mils') }}</option>
                    <option value="yards" @if($amzItem->height_measure == 'yards') selected> @endif{{ trans('tcb-amazon-sync::items.yards') }}</option>
                    <option value="picometre" @if($amzItem->height_measure == 'picometre') selected @endif>{{ trans('tcb-amazon-sync::items.picometre') }}</option>
                    <option value="miles" @if($amzItem->height_measure == 'miles') selected @endif>{{ trans('tcb-amazon-sync::items.miles') }}</option>
                    <option value="decimeters" @if($amzItem->height_measure == 'decimeters') selected @endif>{{ trans('tcb-amazon-sync::items.decimeters') }}</option>
                    <option value="millimeters" @if($amzItem->height_measure == 'millimeters') selected @endif>{{ trans('tcb-amazon-sync::items.millimeters') }}</option>
                    <option value="meters" @if($amzItem->height_measure == 'meters') selected @endif>{{ trans('tcb-amazon-sync::items.meters') }}</option>
                    <option value="inches" @if($amzItem->height_measure == 'inches') selected @endif>{{ trans('tcb-amazon-sync::items.inches') }}</option>
                    <option value="feet" @if($amzItem->height_measure == 'feet') selected @endif>{{ trans('tcb-amazon-sync::items.feet') }}</option>
                    <option value="centimeters" @if($amzItem->height_measure == 'centimeters') selected @endif>{{ trans('tcb-amazon-sync::centimeters.angstrom') }}</option>
                </select>
            </div>
                
            {{ Form::textGroup('length', trans('tcb-amazon-sync::items.length'), 'fas fa-ruler', [], !empty($amzItem->length) ? $amzItem->length : '', 'col-md-3') }}
        
            <div class="form-group col-md-3">
                <label for="length_measure" class="form-control-label">{{ trans('tcb-amazon-sync::items.lengthmeasure') }}</label>
                <select name="length_measure" class="form-control tcb-select">
                    <option class="el-select-dropdown__item" value="">{{ trans('tcb-amazon-sync::general.settings.select') }} Option</option>
                    <option value="angstrom" @if($amzItem->height_measure == 'angstrom') selected @endif>{{ trans('tcb-amazon-sync::items.angstrom') }}</option>
                    <option value="mils" @if($amzItem->height_measure == 'mils') selected @endif>{{ trans('tcb-amazon-sync::items.mils') }}</option>
                    <option value="yards" @if($amzItem->height_measure == 'yards') selected @endif>{{ trans('tcb-amazon-sync::items.yards') }}</option>
                    <option value="picometre" @if($amzItem->height_measure == 'picometre') selected @endif>{{ trans('tcb-amazon-sync::items.picometre') }}</option>
                    <option value="miles" @if($amzItem->height_measure == 'miles') selected @endif>{{ trans('tcb-amazon-sync::items.miles') }}</option>
                    <option value="decimeters" @if($amzItem->height_measure == 'decimeters') selected @endif>{{ trans('tcb-amazon-sync::items.decimeters') }}</option>
                    <option value="millimeters" @if($amzItem->height_measure == 'millimeters') selected @endif>{{ trans('tcb-amazon-sync::items.millimeters') }}</option>
                    <option value="meters" @if($amzItem->height_measure == 'meters') selected @endif>{{ trans('tcb-amazon-sync::items.meters') }}</option>
                    <option value="inches" @if($amzItem->height_measure == 'inches') selected @endif>{{ trans('tcb-amazon-sync::items.inches') }}</option>
                    <option value="feet" @if($amzItem->height_measure == 'feet') selected @endif>{{ trans('tcb-amazon-sync::items.feet') }}</option>
                    <option value="centimeters" @if($amzItem->height_measure == 'centimeters') selected @endif>{{ trans('tcb-amazon-sync::centimeters.angstrom') }}</option>
                </select>
            </div>
                
            {{ Form::textGroup('width', trans('tcb-amazon-sync::items.width'), 'fas fa-ruler-horizontal', [], !empty($amzItem->width) ? $amzItem->width : '', 'col-md-3') }}
        
            <div class="form-group col-md-3">
                <label for="width_measure" class="form-control-label">{{ trans('tcb-amazon-sync::items.widthmeasure') }}</label>
                <select name="width_measure" class="form-control tcb-select">
                    <option class="el-select-dropdown__item" value="">{{ trans('tcb-amazon-sync::general.settings.select') }} Option</option>
                    <option value="angstrom" @if($amzItem->height_measure == 'angstrom') selected @endif>{{ trans('tcb-amazon-sync::items.angstrom') }}</option>
                    <option value="mils" @if($amzItem->height_measure == 'mils') selected @endif>{{ trans('tcb-amazon-sync::items.mils') }}</option>
                    <option value="yards" @if($amzItem->height_measure == 'yards') selected @endif>{{ trans('tcb-amazon-sync::items.yards') }}</option>
                    <option value="picometre" @if($amzItem->height_measure == 'picometre') selected @endif>{{ trans('tcb-amazon-sync::items.picometre') }}</option>
                    <option value="miles" @if($amzItem->height_measure == 'miles') selected @endif>{{ trans('tcb-amazon-sync::items.miles') }}</option>
                    <option value="decimeters" @if($amzItem->height_measure == 'decimeters') selected @endif>{{ trans('tcb-amazon-sync::items.decimeters') }}</option>
                    <option value="millimeters" @if($amzItem->height_measure == 'millimeters') selected @endif>{{ trans('tcb-amazon-sync::items.millimeters') }}</option>
                    <option value="meters" @if($amzItem->height_measure == 'meters') selected @endif>{{ trans('tcb-amazon-sync::items.meters') }}</option>
                    <option value="inches" @if($amzItem->height_measure == 'inches') selected @endif>{{ trans('tcb-amazon-sync::items.inches') }}</option>
                    <option value="feet" @if($amzItem->height_measure == 'feet') selected @endif>{{ trans('tcb-amazon-sync::items.feet') }}</option>
                    <option value="centimeters" @if($amzItem->height_measure == 'centimeters') selected @endif>{{ trans('tcb-amazon-sync::centimeters.centimeters') }}</option>
                </select>
            </div>
                
            {{ Form::textGroup('weight', trans('tcb-amazon-sync::items.weight'), 'fas fa-weight-hanging', [], !empty($amzItem->weight) ? $amzItem->weight : '', 'col-md-3') }}
        
            <div class="form-group col-md-3">
                <label for="weight_measure" class="form-control-label">{{ trans('tcb-amazon-sync::items.weightmeasure') }}</label>
                <select name="weight_measure" class="form-control tcb-select">
                    <option class="el-select-dropdown__item" value="">{{ trans('tcb-amazon-sync::general.settings.select') }} Option</option>
                    <option value="LB" @if($amzItem->height_measure == 'LB') selected @endif>{{ trans('tcb-amazon-sync::items.LB') }}</option>
                    <option value="KG" @if($amzItem->height_measure == 'KG') selected @endif>{{ trans('tcb-amazon-sync::items.KG') }}</option>
                    <option value="GR" @if($amzItem->height_measure == 'GR') selected @endif>{{ trans('tcb-amazon-sync::items.GR') }}</option>
                    <option value="MG" @if($amzItem->height_measure == 'MG') selected @endif>{{ trans('tcb-amazon-sync::items.MG') }}</option>
                    <option value="OZ" @if($amzItem->height_measure == 'OZ') selected @endif>{{ trans('tcb-amazon-sync::items.OZ') }}</option>
                </select>
            </div>
                
            {{ Form::textGroup('color', trans('tcb-amazon-sync::items.color'), 'fas fa-tint', [], !empty($amzItem->color) ? $amzItem->color : '', 'col-md-3') }}
                
            {{ Form::textGroup('material', trans('tcb-amazon-sync::items.material'), 'fas fa-cubes', [], !empty($amzItem->material) ? $amzItem->material : '', 'col-md-3') }}

            {{ Form::textGroup('lead_time_to_ship_max_days', trans('tcb-amazon-sync::items.shipmaxdays'), 'fas fa-calendar-day', [], !empty($amzItem->lead_time_to_ship_max_days) ? $amzItem->lead_time_to_ship_max_days : '', 'col-md-3') }}

            {{ Form::textGroup('country_of_origin', trans('tcb-amazon-sync::items.countryorigin'), 'fas fa-globe-europe', [], !empty($amzItem->country_of_origin) ? $amzItem->country_of_origin : '', 'col-md-3') }}

            <div class="card-footer with-border col-md-12">
                <h3 class="card-title">{{ trans('tcb-amazon-sync::items.category') }}</h3>
                <a id="updateAmazonCategory" title="Update Category on Amazon" class="tcb-tip bg-warning text-white p-1"><i class="fas fa-sync-alt"></i></a>
            </div>

            <p class="col-md-8 tcb-helptext p-3">
                Find your category at <a href="{{ route('tcb-amazon-sync.amazon.categories') }}" target="_blank">Amazon Categories List</a>, and enter UK Node ID value. Or click on the "!" icon.</br>
                <a style="font-weight: bold; font-size: 14px">Selected: <span style="color: rgb(175, 2, 2)">{{ !empty($catName) ? $catName : '' }}</span></a>
                <a data-toggle="modal" data-target="#checkCategories" title="Check All Categories" class="tcb-tip tcb-extra-button text-danger" style="font-size: 20px"><i class="fas fa-exclamation-circle"></i></a>
            </p>

            {{ Form::textGroup('category_id', trans('tcb-amazon-sync::items.category'), 'fas fa-list', ['help' => 'Help Text'], !empty($amzItem->category_id) ? $amzItem->category_id : '', 'col-md-4') }}

            <div class="card-footer with-border col-md-12">
                    <a id="updateAmazonBulletPoints" title="Update Bulletpoints on Amazon" class="tcb-tip bg-warning text-white p-1"><i class="fas fa-sync-alt"></i></a>
                    <h3 class="card-title">{{ trans('tcb-amazon-sync::items.bulletpoints') }}</h3>
            </div>

            {{ Form::textGroup('bullet_point_1', trans('tcb-amazon-sync::items.bullet_point_1'), 'fas fa-dot-circle', [], !empty($amzItem->bullet_point_1) ? $amzItem->bullet_point_1 : '', 'col-md-6') }}

            {{ Form::textGroup('bullet_point_2', trans('tcb-amazon-sync::items.bullet_point_2'), 'fas fa-dot-circle', [], !empty($amzItem->bullet_point_2) ? $amzItem->bullet_point_2 : '', 'col-md-6') }}

            {{ Form::textGroup('bullet_point_3', trans('tcb-amazon-sync::items.bullet_point_3'), 'fas fa-dot-circle', [], !empty($amzItem->bullet_point_3) ? $amzItem->bullet_point_3 : '', 'col-md-6') }}

            {{ Form::textGroup('bullet_point_4', trans('tcb-amazon-sync::items.bullet_point_4'), 'fas fa-dot-circle', [], !empty($amzItem->bullet_point_4) ? $amzItem->bullet_point_4 : '', 'col-md-6') }}

            {{ Form::textGroup('bullet_point_5', trans('tcb-amazon-sync::items.bullet_point_5'), 'fas fa-dot-circle', [], !empty($amzItem->bullet_point_5) ? $amzItem->bullet_point_5 : '', 'col-md-6') }}

            {{ Form::textGroup('bullet_point_6', trans('tcb-amazon-sync::items.bullet_point_6'), 'fas fa-dot-circle', [], !empty($amzItem->bullet_point_6) ? $amzItem->bullet_point_6 : '', 'col-md-6') }}

            <div class="card-footer with-border col-md-12">
                <a id="updateAmazonDescription" title="Update Description on Amazon" class="tcb-tip bg-warning text-white p-1"><i class="fas fa-sync-alt"></i></a>
                {{ Form::textareaGroup('description', trans('tcb-amazon-sync::items.description'), [], !empty($amzItem->description) ? $amzItem->description : '') }}
            </div>

            <div class="card-footer with-border col-md-12">
                <a id="updateAmazonKeywords" title="Update Keywords on Amazon" class="tcb-tip bg-warning text-white p-1"><i class="fas fa-sync-alt"></i></a>
                {{ Form::textareaGroup('keywords', trans('tcb-amazon-sync::items.keywords'), [], !empty($amzItem->keywords) ? $amzItem->keywords : '') }}
            </div>

            <div class="card-footer with-border col-md-12">
                <a id="updateAmazonImages" title="Update Images on Amazon" class="tcb-tip bg-warning text-white p-1"><i class="fas fa-sync-alt"></i></a>
                <h3 class="card-title">{{ trans('tcb-amazon-sync::items.images.images') }}</h3>
            </div>
        
            <div class="form-group col-md-6" id="mainPicture">
                <label class="" for="enable">{{ trans('tcb-amazon-sync::items.images.mainpic') }}</label>
                <input id="mainPic" type="file" name="main_picture" accept=".jpg, .png, image/jpeg, image/png" data-image="{{ !empty($amzItem->main_picture) ?  $amzItem->main_picture : '' }}">
            </div>
            <div class="form-group col-md-6" id="">
            </div>

            <div class="form-group col-md-4" id="picture_1">
                <label class="" for="enable">{{ trans('tcb-amazon-sync::items.images.pic1') }}</label>
                <input id="pic1" type="file" name="picture_1" accept=".jpg, .png, image/jpeg, image/png" data-image="{{ !empty($amzItem->picture_1) ? $amzItem->picture_1 : '' }}">
            </div>
            
            <div class="form-group col-md-4" id="picture_2">
                <label class="" for="enable">{{ trans('tcb-amazon-sync::items.images.pic2') }}</label>
                <input id="pic2" type="file" name="picture_2" accept=".jpg, .png, image/jpeg, image/png" data-image="{{ !empty($amzItem->picture_2) ? $amzItem->picture_2 : '' }}">
            </div>

            <div class="form-group col-md-4" id="picture_3">
                <label class="" for="enable">{{ trans('tcb-amazon-sync::items.images.pic3') }}</label>
                <input id="pic3" type="file" name="picture_3" accept=".jpg, .png, image/jpeg, image/png" data-image="{{ !empty($amzItem->picture_3) ? $amzItem->picture_3 : '' }}">
            </div>

            <div class="form-group col-md-4" id="picture_4">
                <label class="" for="enable">{{ trans('tcb-amazon-sync::items.images.pic4') }}</label>
                <input id="pic4" type="file" name="picture_4" accept=".jpg, .png, image/jpeg, image/png" data-image="{{ !empty($amzItem->picture_4) ? $amzItem->picture_4 : '' }}">
            </div>

            <div class="form-group col-md-4" id="picture_5">
                <label class="" for="enable">{{ trans('tcb-amazon-sync::items.images.pic5') }}</label>
                <input id="pic5" type="file" name="picture_5" accept=".jpg, .png, image/jpeg, image/png" data-image="{{ !empty($amzItem->picture_4) ? $amzItem->picture_5 : '' }}">
            </div>

            <div class="form-group col-md-4" id="picture_6">
                <label class="" for="enable">{{ trans('tcb-amazon-sync::items.images.pic6') }}</label>
                <input id="pic6" type="file" name="picture_6" accept=".jpg, .png, image/jpeg, image/png" data-image="{{ !empty($amzItem->picture_6) ? $amzItem->picture_6 : '' }}">
            </div>
        </div>
    </div>
    {!! Form::close() !!}
    <div class="card-footer">
        <div class="row save-buttons col-md-12 text-center">
                <a href="{{ route('tcb-amazon-sync.amazon.items.index', [$country]) }}" class="btn btn-danger btn-sm">{{ trans('tcb-amazon-sync::items.backtoindex') }}</a>
                <button data-url="{{route('tcb-amazon-sync.items.update', ['id' => $amzItem->id])}}" id="saveAmazonItem" class="btn btn-sm btn-icon btn-success">
                    <span class="btn-inner--text">{{ trans('tcb-amazon-sync::items.amazon.save') }}</span>
                </button>
            @if($amzItem->is_uploaded_uk)
                <button id="fetchAmazonItem" class="shadow btn btn-sm btn-icon btn-info" data-url="{{ route('tcb-amazon-sync.amazon.item.get', ['id' => $amzItem->id, 'country' => 'Uk']) }}">
                    <span class="btn-inner--text">{{ trans('tcb-amazon-sync::items.amazon.fetch') }} - UK</span>
                </button>
                <button id="updateAmazonItem" class="shadow btn btn-sm btn-icon btn-danger" data-url="{{ route('tcb-amazon-sync.amazon.item.updateOnline', ['id' => $amzItem->id, 'country' => 'Uk']) }}">
                    <span class="btn-inner--text">{{ trans('tcb-amazon-sync::items.amazon.updateonline') }} - UK</span>
                </button>
            @else
                <button id="uploadAmazonItem" class="shadow btn btn-sm btn-icon btn-info" data-url="{{ route('tcb-amazon-sync.amazon.item.upload', ['id' => $amzItem->id, 'country' => 'Uk']) }}">
                    <span class="btn-inner--text">{{ trans('tcb-amazon-sync::items.amazon.upload') }} - UK</span>
                </button>
            @endif
        </div>
        <div class="col-md-12">
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

<div id="checkCategories" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="checkProductType" aria-hidden="true">
    <div class="card">
        <button id="" type="button" class="closeModal btn btn-danger ml-auto" data-dismiss="#checkCategories"><i class="fas fa-window-close"></i></button>
        <div id="categoriesHeader" class="card-header border-bottom-0" :class="[{'bg-gradient-primary': bulk_action.show}]">
            <div class="align-items-center" v-if="!bulk_action.show">
                <h3>AMAZON CATEGORIES - FIND THE CATEGORY ID HERE</h3>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="amzCategoriesSmall" data-route="{{ route('tcb-amazon-sync.amazon.categories.datatables') }}" class="fresh-table table table-flush dataTable table-hover table-striped" style="width:100%">
                    <thead class="thead-light">
                        <tr>
                            <th>ID</th>
                            <th>{{ trans('tcb-amazon-sync::general.category.path') }}</th>
                            <th>{{ trans('tcb-amazon-sync::general.category.rootcat') }}</th>
                            <th>{{ trans('tcb-amazon-sync::general.category.ukid') }}</th>
                            <th>{{ trans('tcb-amazon-sync::general.category.deid') }}</th>
                            <th>{{ trans('tcb-amazon-sync::general.category.frid') }}</th>
                            <th>{{ trans('tcb-amazon-sync::general.category.itid') }}</th>
                            <th>{{ trans('tcb-amazon-sync::general.category.esid') }}</th>
                        </tr>
                    </thead>
                    <tfoot class="thead-light">
                        <tr>
                            <th>ID</th>
                            <th>{{ trans('tcb-amazon-sync::general.category.path') }}</th>
                            <th>{{ trans('tcb-amazon-sync::general.category.rootcat') }}</th>
                            <th>{{ trans('tcb-amazon-sync::general.category.ukid') }}</th>
                            <th>{{ trans('tcb-amazon-sync::general.category.deid') }}</th>
                            <th>{{ trans('tcb-amazon-sync::general.category.frid') }}</th>
                            <th>{{ trans('tcb-amazon-sync::general.category.itid') }}</th>
                            <th>{{ trans('tcb-amazon-sync::general.category.esid') }}</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        <div class="card-footer">
        </div>
    </div>
</div>

<div id="checkProductType" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="checkProductType" aria-hidden="true">
    <div class="card">
        <button id="" type="button" class="closeModal btn btn-danger ml-auto" data-dismiss="#checkProductType"><i class="fas fa-window-close"></i></button>
        <div class="card-header border-bottom-0" :class="[{'bg-gradient-primary': bulk_action.show}]">
            <div class="col-md-12">
                <h3>{{ trans('tcb-amazon-sync::general.ptwarning') }}</h3>
            </div>
            <div class="col-md-3">
                <button id="uploadAmazonItem" class="btn btn-sm btn-icon btn-info" data-url="{{ route('tcb-amazon-sync.amazon.getProductTypes') }}">
                    <span class="btn-inner--text">{{ trans('tcb-amazon-sync::general.updatepts') }}</span>
                </button>
            </div>
        </div>

        <div class="table-responsive">
            <table id="ptDataTableSmall" class="table table-flush table-hover" data-route="{{ route('tcb-amazon-sync.amazon.producttype.datatables') }}">
                <thead class="thead-light">
                    <tr>
                        <th>ID</th>
                        <th>{{ trans('general.name') }}</th>
                        <th>{{ trans('tcb-amazon-sync::general.settings.uk') }}</th>
                        <th>{{ trans('tcb-amazon-sync::general.settings.de') }}</th>
                        <th>{{ trans('tcb-amazon-sync::general.settings.fr') }}</th>
                        <th>{{ trans('tcb-amazon-sync::general.settings.it') }}</th>
                        <th>{{ trans('tcb-amazon-sync::general.settings.es') }}</th>
                        <th>{{ trans('tcb-amazon-sync::general.settings.se') }}</th>
                        <th>{{ trans('tcb-amazon-sync::general.settings.nl') }}</th>
                        <th>{{ trans('tcb-amazon-sync::general.settings.pl') }}</th>
                        <th>{{ trans('tcb-amazon-sync::general.settings.us') }}</th>
                        <th>{{ trans('tcb-amazon-sync::general.settings.ca') }}</th>
                    </tr>
                </thead>
                <tfoot class="thead-light">
                    <tr>
                        <th>ID</th>
                        <th>{{ trans('general.name') }}</th>
                        <th>{{ trans('tcb-amazon-sync::general.settings.uk') }}</th>
                        <th>{{ trans('tcb-amazon-sync::general.settings.de') }}</th>
                        <th>{{ trans('tcb-amazon-sync::general.settings.fr') }}</th>
                        <th>{{ trans('tcb-amazon-sync::general.settings.it') }}</th>
                        <th>{{ trans('tcb-amazon-sync::general.settings.es') }}</th>
                        <th>{{ trans('tcb-amazon-sync::general.settings.se') }}</th>
                        <th>{{ trans('tcb-amazon-sync::general.settings.nl') }}</th>
                        <th>{{ trans('tcb-amazon-sync::general.settings.pl') }}</th>
                        <th>{{ trans('tcb-amazon-sync::general.settings.us') }}</th>
                        <th>{{ trans('tcb-amazon-sync::general.settings.ca') }}</th>
                    </tr>
                </tfoot>
            </table>
        </div>

        <div class="card-footer table-action">
            <div class="row align-items-center">
            </div>
        </div>
    </div>
</div>
<div id="successModal" class="modal fade">
    <div class="modal-dialog modal-danger modal-dialog-centered modal-">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-title">

                </div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-white">{{ trans('tcb-amazon-sync::general.closemodal') }}</button>
            </div>
        </div>
    </div>
</div>