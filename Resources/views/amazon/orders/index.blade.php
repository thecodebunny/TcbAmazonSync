@extends('tcb-amazon-sync::layouts.tcbmaster')

@section('title', trans_choice('general.items', 2))

@push('css')
    <link rel="stylesheet" href="{{ asset('modules/TcbAmazonSync/Resources/assets/css/tcb.css?v=' . module_version('tcb-amazon-sync')) }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('modules/TcbAmazonSync/Resources/assets/css/items.css?v=' . module_version('tcb-amazon-sync')) }}" type="text/css">
@endpush

@section('content')
    @if ($orders->count())
        <div class="card-header border-bottom-0" :class="[{'bg-gradient-primary': bulk_action.show}]">
            {!! Form::open([
                'method' => 'GET',
                'route' => 'tcb-amazon-sync.amazon.orders.index',
                'role' => 'form',
                'class' => 'mb-0'
            ]) !!}
                <div class="align-items-center" v-if="!bulk_action.show">
                    <x-search-string model="Modules\TcbAmazonSync\Models\Amazon\Order" />
                </div>
            {!! Form::close() !!}
        </div>
    @endif

    <div class="table-responsive">
        <table class="table table-flush table-hover">
            <thead class="thead-light">
                <tr class="row table-head-line">
                    <th class="col-sm-2 col-md-2 col-lg-1 col-xl-1 d-none d-sm-block">{{ Form::bulkActionAllGroup() }}</th>
                    <th class="col-xs-4 col-sm-4 col-md-3 col-lg-1 col-xl-1">@sortablelink('purchase_date', trans('general.date'), ['filter' => 'active, visible'], ['class' => 'col-aka', 'rel' => 'nofollow'])</th>
                    <th class="col-xs-4 col-sm-4 col-md-3 col-lg-2 col-xl-2 text-right">@sortablelink('order_total', trans('general.amount'))</th>
                    <th class="col-md-2 col-lg-3 col-xl-3 d-none d-md-block text-left">{{ trans_choice('tcb-amazon-sync::orders.status', 1)}}</th>
                    <th class="col-xs-4 col-sm-4 col-md-3 col-lg-2 col-xl-2 text-right">{{ trans('tcb-amazon-sync::orders.amzchannel') }}</th>
                    <th class="col-md-2 col-lg-3 col-xl-3 d-none d-md-block text-left">{{ trans_choice('general.customers', 1)}}</th>
                    <th class="col-xs-4 col-sm-2 col-md-2 col-lg-1 col-xl-1 text-center"><a>{{ trans('general.actions') }}</a></th>
                </tr>
            </thead>

            <tbody>
                @foreach($orders as $item)
                    <tr class="row align-items-center border-top-1">
                        <td class="col-sm-2 col-md-2 col-lg-1 col-xl-1 d-none d-sm-block">{{ Form::bulkActionGroup($item->id, $item->contact->name) }}</td>
                        @if ($item->reconciled)
                            <td class="col-xs-4 col-sm-4 col-md-3 col-lg-1 col-xl-1"><a class="col-aka" href="#">@date($item->purchase_date)</a></td>
                        @else
                            <td class="col-xs-4 col-sm-4 col-md-3 col-lg-1 col-xl-1"><a class="col-aka" href="{{ route('tcb-amazon-sync.amazon.orders.show', $item->id) }}">@date($item->purchase_date)</a></td>
                        @endif
                        <td class="col-xs-4 col-sm-4 col-md-3 col-lg-2 col-xl-2 text-right">@money($item->order_total, $item->currency_code, true)</td>
                        <td class="col-xs-4 col-sm-4 col-md-3 col-lg-2 col-xl-2 text-right" @if ($item->order_status !== 'Shipped') style="color: red;" @endif>{{ $item->order_status }}</td>
                        <td class="col-xs-4 col-sm-4 col-md-3 col-lg-2 col-xl-2 text-right">{{ $item->marketplace }}</td>
                        <td class="col-md-2 col-lg-3 col-xl-3 d-none d-md-block text-left">
                            {{ $item->contact->name }}
                        </td>
                        <td class="col-xs-4 col-sm-2 col-md-2 col-lg-1 col-xl-1 text-center">
                            <div class="dropdown">
                                <a class="btn btn-neutral btn-sm text-light items-align-center py-2" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-ellipsis-h text-muted"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                    <a class="dropdown-item" href="{{ route('tcb-amazon-sync.amazon.orders.show', $item->id) }}">{{ trans('general.show') }}</a>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="card-footer table-action">
        <div class="row">
            {{ $orders->links() }}
        </div>
    </div>
@stop