@extends('tcb-amazon-sync::layouts.tcbmaster')

@section('title', "Warehouses")

@section('new_button')
    <a href="{{ route('tcb-amazon-sync.amazon.warehouses.create') }}" class="btn btn-info btn-sm">{{ trans('tcb-amazon-sync::general.create') }} {{ trans('tcb-amazon-sync::warehouse.warehouse') }}</a>
@endsection

@section('content')
<div class="card">
    @if ($warehouses->count())
        
            <div class="card-header border-bottom-0" :class="[{'bg-gradient-primary': bulk_action.show}]">
                {!! Form::open([
                    'method' => 'GET',
                    'role' => 'form',
                    'class' => 'mb-0'
                ]) !!}
                    <div class="align-items-center" v-if="!bulk_action.show">
                        <x-search-string model="Modules\TcbAmazonSync\Models\Amazon\Warehouse" />
                    </div>
                {!! Form::close() !!}
            </div>

            <div class="table-responsive">
                <table class="table table-flush table-hover">
                    <thead class="thead-light">
                        <tr class="row table-head-line">
                            <th class="col-sm-2 col-md-1 col-lg-1 col-xl-1 d-none d-sm-block">{{ Form::bulkActionAllGroup() }}</th>
                            <th class="col-xs-3 col-sm-3 col-md-3 col-lg-2 col-xl-3">@sortablelink('name', trans('general.name'), ['filter' => 'active, visible'], ['class' => 'col-aka', 'rel' => 'nofollow'])</th>
                            <th class="col-lg-2 col-xl-2 d-none d-lg-block">{{ trans_choice('tcb-amazon-sync::warehouse.enabled', 1) }}</th>
                            <th class="col-lg-2 col-xl-2 text-center d-none d-md-block">{{ trans('tcb-amazon-sync::warehouse.defaultWarehouse') }}</th>
                            <th class="col-md-2 col-lg-2 col-xl-1 text-right d-none d-md-block">{{ trans('tcb-amazon-sync::warehouse.city') }}</th>
                            <th class="col-lg-2 col-xl-2 text-right d-none d-lg-block">{{ trans('tcb-amazon-sync::warehouse.country') }}</th>
                            <th class="col-xs-2 col-sm-2 col-md-1 col-lg-1 col-xl-1 text-center"><a>{{ trans('general.actions') }}</a></th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($warehouses as $warehouse)
                        <tr class="row align-items-center border-top-1">
                            <td class="col-sm-2 col-md-1 col-lg-1 col-xl-1 d-none d-sm-block">
                                {{ Form::bulkActionGroup($warehouse->id, $warehouse->name) }}
                            </td>
                            <td class="col-xs-3 col-sm-3 col-md-3 col-lg-2 col-xl-3">
                                <a href="{{ route('tcb-amazon-sync.amazon.warehouse.edit', ['id' => $warehouse->id]) }}">{{ $warehouse->name }}</a>
                            </td>
                            <td class="col-lg-2 col-xl-2 d-none d-lg-block">
                                @if($warehouse->enabled == 1) 
                                    <span class="btn btn-success btn-sm "><i class="fas fa-check-circle"></i></span>
                                @else
                                    <span class="btn btn-danger btn-sm "><i class="fas fa-times-circle"></i></span>
                                @endif
                            </td>
                            <td class="col-lg-2 col-xl-2 text-center d-none d-md-block">
                                @if($warehouse->default_warehouse == 1) 
                                    <span class="btn btn-success btn-sm "><i class="fas fa-check-circle"></i></span>
                                @else
                                    <span class="btn btn-danger btn-sm "><i class="fas fa-times-circle"></i></span>
                                @endif
                            </td>
                            <td class="col-md-1 col-lg-1 col-xl-1 text-right d-none d-md-block">
                                {{ $warehouse->city }}
                            </td>
                            <td class="col-lg-2 col-xl-2 text-right d-none d-lg-block">
                                {{ $warehouse->country }}
                            </td>
                            <td class="col-xs-1 col-sm-1 col-md-1 col-lg-1 col-xl-1 text-center">
                                <div class="dropdown">
                                    <a class="btn btn-neutral btn-sm text-light items-align-center p-2" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fa fa-ellipsis-h text-muted"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                        <a class="dropdown-item" href="{{ route('tcb-amazon-sync.amazon.warehouse.edit', $warehouse->id) }}">{{ trans('general.edit') }}</a>
                                        @permission('create-common-items')
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item" href="{{ route('tcb-amazon-sync.amazon.warehouse.duplicate', $warehouse->id) }}">{{ trans('general.duplicate') }}</a>
                                        @endpermission
                                        <div class="dropdown-divider"></div>
                                        <form method="POST">
                                            @csrf
                                            <a id="deleteWarehouse" style="cursor: pointer" class="dropdown-item" route="{{ route('tcb-amazon-sync.amazon.warehouse.destroy', $warehouse->id) }}">{{ trans('tcb-amazon-sync::general.destroy') }}</a>
                                        </form>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
    @else
        <p>
            {{ trans('tcb-amazon-sync::warehouse.nowarehouse') }}
        </p>
    @endif
</div>
@stop

