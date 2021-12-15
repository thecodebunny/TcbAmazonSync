@extends('layouts.admin')

@section('title', trans('general.title.edit', ['type' => trans_choice('general.items', 1)]))

@section('content')
    <div class="card">
        {!! Form::model($item, [
            'id' => 'item',
            'method' => 'PATCH',
            'route' => ['inventory.items.update', $item->id],
            '@submit.prevent' => 'onSubmit',
            '@keydown' => 'form.errors.clear($event.target.name)',
            'files' => true,
            'role' => 'form',
            'class' => 'form-loading-button',
            'novalidate' => true
        ]) !!}

            <div class="card-body">
                <div class="row">
                    {{ Form::textGroup('name', trans('general.name'), 'tag') }}

                    {{ Form::textGroup('sku', trans('inventory::general.sku'), 'fa fa-key', ['required' => 'required'], $sku) }}

                    {{ Form::multiSelectAddNewGroup('tax_ids', trans_choice('general.taxes', 1), 'percentage', $taxes, $item->tax_ids, ['path' => route('modals.taxes.create'), 'field' => ['key' => 'id', 'value' => 'title']], 'col-md-6 el-select-tags-pl-38') }}

                    {{ Form::textareaGroup('description', trans('general.description')) }}

                    {{ Form::textGroup('sale_price', trans('items.sales_price'), 'money-bill-wave') }}

                    {{ Form::textGroup('purchase_price', trans('items.purchase_price'), 'money-bill-wave-alt') }}

                    {{ Form::selectGroup('unit', trans('inventory::general.unit'), 'fas fa-box-open', $units, $item->inventory()->value('unit')) }}

                    {{ Form::selectRemoteAddNewGroup('category_id', trans_choice('general.categories', 1), 'folder', $categories, $item->category_id, ['path' => route('modals.categories.create') . '?type=item', 'remote_action' => route('categories.index'). '?search=type:item']) }}

                    {{ Form::fileGroup('picture', trans_choice('general.pictures', 1), '', ['dropzone-class' => 'form-file', 'options' => ['acceptedFiles' => 'image/*']]) }}

                    {{ Form::radioGroup('enabled', trans('general.enabled'), $item->enabled) }}

                    <div class="row col-md-12">
                        <div class="form-group col-md-12 margin-top">
                            <div class="custom-control custom-checkbox">
                                {{ Form::checkbox('returnable', '1', $item->inventory()->value('returnable'), [
                                    'class' => 'custom-control-input',
                                    'id' => 'returnable',
                                    '@input' => 'onCanReturnable($event)'
                                 ]) }}

                                <label class="custom-control-label" for="returnable">
                                    <strong>{{ trans('inventory::general.returnable') }}</strong>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div id="track_inventories" class="row col-md-12">
                        @stack('track_inventory_input_start')
                            <div id="item-track-inventory" class="form-group col-md-12 margin-top">
                                <div class="custom-control custom-checkbox">
                                    {{ Form::checkbox('track_inventory', '1', $track_control, [
                                        'v-model' => 'form.track_inventory',
                                        'id' => 'track_inventory',
                                        'class' => 'custom-control-input'
                                    ]) }}

                                    <label class="custom-control-label" for="track_inventory">
                                        <strong>{{ trans('inventory::items.track_inventory')}}</strong>
                                    </label>
                                </div>
                            </div>
                        @stack('track_inventory_input_end')
                    </div>
                    <div v-if="form.track_inventory.length" class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="items">
                                <thead class="thead-light">
                                    <tr class="row">
                                        <th class="col-md-1">{{ trans('general.actions') }}</th>
                                        <th class="col-md-5">{{ trans_choice('inventory::general.warehouses', 1) }}</th>
                                        <th class="col-md-2">{{ trans('inventory::items.total_stock') }}</th>
                                        <th class="col-md-2">{{ trans('inventory::items.opening_stock') }}</th>
                                        <th class="col-md-2">{{ trans('inventory::items.reorder_level') }}</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <tr class="row" v-for="(row, index) in form.items">
                                        <td class="col-md-1">
                                            <button type="button"
                                                @click="onDeleteItem(index)"
                                                data-toggle="tooltip"
                                                title="{{ trans('general.delete') }}"
                                                class="btn btn-icon btn-outline-danger btn-lg"><i class="fa fa-trash"></i>
                                            </button>
                                        </td>
                                        <td class="col-md-5">
                                            <div class="row">
                                                <div class="custom-radio col-md-2 p-3">
                                                    <input type="radio"
                                                        name="items[][default_warehouse]"
                                                        :id="'default-warehouse-' + index"
                                                        data-item="default_warehouse"
                                                        :value="'true'"
                                                        @change="onChangeDefault(index)"
                                                        v-model="row.default_warehouse"
                                                        class="custom-control-input">
                                                    <label :for="'default-warehouse-' + index" class="custom-control-label">
                                                        {{ trans('inventory::general.default') }}
                                                    </label>
                                                </div>

                                                <akaunting-select
                                                    class="form-control-sm d-inline-block col-md-10"
                                                    :placeholder="'{{ trans('general.form.select.field', ['field' => trans_choice('inventory::general.warehouses', 1)])  }}'"
                                                    :name="'items.' + index + '.warehouse_id'"
                                                    :icon="'fas fa-warehouse'"
                                                    :options="{{ json_encode($warehouses) }}"
                                                    :value="row.warehouse_id"
                                                    @interface="row.warehouse_id = $event"
                                                    >
                                                </akaunting-select>
                                            </div>
                                        </td>
                                        <td class="col-md-2">
                                            <input value=""
                                            class="form-control"
                                            disabled
                                            data-item="opening_stock"
                                            required="required"
                                            name="items.' + index + '.opening_stock'"
                                            v-model="row.opening_stock"
                                            type="text"
                                            autocomplete="off">

                                            @if (!setting('inventory.negatif_stock'))
                                                <div class="invalid-feedback d-block"
                                                    v-if="opening_stock_error[index] && form.errors.has('items.' + index + '.opening_stock')"
                                                    v-html="form.errors.get('items.' + index + '.opening_stock')">
                                                </div>
                                            @endif

                                            <input value=""
                                            class="form-control"
                                            data-item="default_opening_stock"
                                            name="items.' + index + '.default_opening_stock'"
                                            v-model="row.default_opening_stock"
                                            type="hidden"
                                            autocomplete="off">
                                        </td>
                                        <td class="col-md-2">
                                            <input value=""
                                            class="form-control"
                                            data-item="opening_stock_value"
                                            required="required"
                                            name="items.' + index + '.opening_stock_value'"
                                            v-model="row.opening_stock_value"
                                            type="text"
                                            @input="onChangeOpeningStockValue(index, {{ setting('inventory.negatif_stock') }})"
                                            autocomplete="off">

                                            <input value=""
                                            class="form-control"
                                            data-item="default_opening_stock_value"
                                            name="items[][default_opening_stock_value]"
                                            v-model="row.default_opening_stock_value"
                                            type="hidden"
                                            autocomplete="off">
                                        </td>
                                        <td class="col-md-2">
                                            <input value=""
                                            class="form-control"
                                            data-item="reorder_level"
                                            required="required"
                                            name="items[][reorder_level]"
                                            v-model="row.reorder_level"
                                            type="text"
                                            autocomplete="off">

                                            <input value=""
                                            class="form-control"
                                            data-item="id"
                                            name="items[][id]"
                                            v-model="row.id"
                                            type="hidden"
                                            autocomplete="off">
                                        </td>
                                    </tr>
                                    <tr id="addItem">
                                        <td class="col-md-1">
                                            <button type="button"
                                                @click="onAddItem"
                                                id="button-add-item"
                                                data-toggle="tooltip"
                                                title="{{ trans('general.add') }}"
                                                class="btn btn-icon btn-outline-success btn-lg"
                                                data-original-title="{{ trans('general.add') }}">
                                                <i class="fa fa-plus"></i>
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            @permission('update-common-items')
                <div class="card-footer">
                    <div class="row save-buttons">
                        <div class="col-md-12">
                            <a href="{{ route('inventory.items.index') }}" class="btn btn-icon btn-outline-secondary header-button-top">
                                <span class="btn-inner--text">{{ trans('general.cancel') }}</span>
                            </a>
                            {!! Form::button(
                                '<span v-if="form.loading" class="btn-inner--icon"><i class="aka-loader"></i></span>' .
                                '<span :class="[{\'opacity-10\': item_button}]" class="btn-inner--text"> ' . trans('general.save') . '</span>',
                                [':disabled' => 'item_button|| form.loading', 'type' => 'submit', 'class' => 'btn btn-icon btn-success button-submit header-button-top', 'data-loading-text' => trans('general.loading')])
                            !!}
                        </div>
                    </div>
                </div>
            @endpermission

        {!! Form::close() !!}
    </div>
@endsection

@push('scripts_start')x
@endpush
