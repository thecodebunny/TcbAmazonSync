@extends('tcb-amazon-sync::layouts.tcbmaster')

@section('title', trans('tcb-amazon-sync::orders.amzorder'))

@section('new_button')
    @if($order->order_status !== 'Shipped')
        <a href="" class="btn btn-danger btn-sm">
            {{ trans('tcb-amazon-sync::general.ship') }}
        </a>
    @endif
@endsection

@push('css')
    <link rel="stylesheet"
        href="{{ asset('modules/TcbAmazonSync/Resources/assets/css/tcb.css?v=' . module_version('tcb-amazon-sync')) }}"
        type="text/css">
    <link rel="stylesheet"
        href="{{ asset('modules/TcbAmazonSync/Resources/assets/css/items.css?v=' . module_version('tcb-amazon-sync')) }}"
        type="text/css">
@endpush

@section('content')
    <div class="row bg-info rounded mb-4" style="font-size: inherit !important;">
        <div class="col-4 col-lg-5 pt-3">
            {{ trans('tcb-amazon-sync::general.amzordernumber') }}
            <br>
            <strong>
                <span class="float-left mwpx-200 transaction-head-text">
                    <a>
                        {{ $order->amazon_order_id }}
                    </a>
                </span>
            </strong> 
            <br>
            <br>
        </div>
        <div class="col-4 col-lg-5 pt-3">
            @if($order->order_status !== 'Shipped')
                {{ trans('tcb-amazon-sync::general.trackingids') }}
                <br>
                <strong>
                    <span class="float-left mwpx-200 transaction-head-text">
                        @if ($order->tracking_id_1) {{ $order->tracking_id_1 }} @endif <br>
                        @if ($order->tracking_id_2) {{ $order->tracking_id_2 }} @endif <br>
                        @if ($order->tracking_id_3) {{ $order->tracking_id_3 }} @endif
                    </span>
                </strong> 
                <br>
                <br>
            @endif
        </div>
        <div class="col-lg-2 bg-primary text-white text-center pt-2 pb-2 rounded-right">
            <h3 class="text-white text-center">{{ trans('tcb-amazon-sync::orders.amount') }}</h3>
            <h3 class="text-white text-center">{{ $order->currency_code }} {{ $order->order_total }}</h3>
        </div>
    </div>
    <div class="card row show-card p-3">
        <table class="border-bottom p-3 bg-secondary">
            <tbody>
                <tr>
                    <td class="align-top" style="width: 5%">
                        <img src="{{Storage::url(setting('company.logo'))}}" width="120">
                    </td>
                    <td class="align-top" style="width: 60%">
                        <strong>{{ $company->name }}</strong>
                        <br>
                        {{$company->address}}
                        <br>
                        <br>
                        {{$company->email}}
                    </td>
                </tr>
            </tbody>
        </table>
        <h2 class="text-center text-uppercase border-bottom bg-secondary">{{ trans('tcb-amazon-sync::orders.amzorderdetails') }}</h2>
        <table class="border-bottom">
            <tbody>
                <tr>
                    <td style="width: 40%" class="border-top border-left">
                        <table>
                            <tbody>
                                <tr>
                                    <td class="pl-2" style="width: 30%">
                                        <strong>{{ trans('tcb-amazon-sync::orders.date') }} :</strong>
                                    </td>
                                    <td class="p-3" style="width: 40%;">
                                        {{ $order->purchase_date }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="pl-2" style="width: 30%">
                                        <strong>{{ trans('tcb-amazon-sync::orders.amzchannel') }} :</strong>
                                    </td>
                                    <td class="p-3" style="width: 40%;">
                                        {{ $order->marketplace }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="pl-2" style="width: 30%">
                                        <strong>{{ trans('tcb-amazon-sync::orders.asins') }} :</strong>
                                    </td>
                                    <td class="p-3" style="width: 40%;">
                                        {{ $order->asin_ids }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="pl-2" style="width: 30%">
                                        <strong>{{ trans('tcb-amazon-sync::orders.status') }} :</strong>
                                    </td>
                                    <td class="p-3" style="width: 40%;">
                                        {{ $order->order_status }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="pl-2" style="width: 30%">
                                        <strong>{{ trans('tcb-amazon-sync::orders.earlyshipdate') }} :</strong>
                                    </td>
                                    <td class="p-3" style="width: 40%;">
                                        {{ $order->earliest_ship_date }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="pl-2" style="width: 30%">
                                        <strong>{{ trans('tcb-amazon-sync::orders.amzupdatedate') }} :</strong>
                                    </td>
                                    <td class="p-3" style="width: 40%;">
                                        {{ $order->last_update_date }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                    <td class="align-top text-center border-left border-right border-top" style="width: 40%">
                        <h4 class="text-uppercase border-bottom">{{ trans('tcb-amazon-sync::orders.orderitems') }}</h4>
                        <table class="table table-flush table-hover">
                            <thead class="thead-light">
                                <tr class="table-head-line">
                                    <th></th>
                                    <th class="text-center">
                                        {{ trans('tcb-amazon-sync::items.quantity') }}
                                    </th>
                                    <th class="text-center">
                                        {{ trans('tcb-amazon-sync::items.sku') }}
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(count($order->items))
                                    @foreach($order->items as $item)
                                    <tr class="align-items-center border-top-1">
                                        <td class="p-2">
                                            <img src="{{ asset('/public/'. $item->image) }}" width="80">
                                        </td>
                                        <td class="p-2 text-center">
                                            <h5 class="">{{ $item->quantity }}</h5>
                                        </td>
                                        <td class="p-2 text-center">
                                            <h5 class="">{{ $item->sku }}</h5>
                                        </td>
                                    </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </td>
                </tr>
            </tbody>
        </table>
        <h2 class="text-center text-uppercase border-top border-bottom bg-secondary mt-3">{{ trans('tcb-amazon-sync::orders.customerdetails') }}</h2>
        <table class="border-bottom border-left border-right">
            <tbody>
                <tr>
                    <td class="pl-2" style="width: 40%">
                        <strong>{{ trans('tcb-amazon-sync::orders.customername') }} :</strong>
                    </td>
                    <td class="pl-2" style="width: 40%">
                        {{ $order->contact->name }}
                    </td>
                </tr>
                <tr>
                    <td class="pl-2" style="width: 40%">
                        <strong>{{ trans('tcb-amazon-sync::orders.customeremail') }} :</strong>
                    </td>
                    <td class="pl-2" style="width: 40%" class="pt-2 pb-2">
                        {{ $order->contact->email }}
                    </td>
                </tr>
                <tr>
                    <td class="pl-2" style="width: 40%">
                        <strong>{{ trans('tcb-amazon-sync::orders.customeraddress') }} :</strong>
                    </td>
                    <td class="pl-2" style="width: 40%">
                        {!! $order->contact->address !!}<br>
                    </td>
                </tr>
            </tbody>
        </table>
        <h2 class="text-center text-uppercase border-top border-bottom bg-secondary mt-3">{{ trans('tcb-amazon-sync::orders.othercustomerorders') }}</h2>
        
        <table class="table table-flush table-hover">
            <thead class="thead-light">
                <tr class="table-head-line">
                    <th class="text-center">
                        {{ trans('tcb-amazon-sync::orders.date') }}
                    </th>
                    <th class="text-center">
                        {{ trans('tcb-amazon-sync::orders.amzordernumber') }}
                    </th>
                    <th class="text-center">
                        {{ trans('tcb-amazon-sync::orders.amzchannel') }}
                    </th>
                    <th class="text-center">
                        {{ trans('tcb-amazon-sync::orders.amount') }}
                    </th>
                </tr>
            </thead>
            <tbody>
                @if(count($relatedOrders))
                    @foreach($relatedOrders as $item)
                    @if($item->amazon_order_id !== $order->amazon_order_id)
                        <tr class="align-items-center border-top-1">
                            <td class="p-2">
                                {{ $item->purchase_date }}
                            </td>
                            <td class="p-2 text-center">
                                <h5 class="">{{ $item->amazon_order_id }}</h5>
                            </td>
                            <td class="p-2 text-center">
                                <h5 class="">{{ $item->marketplace }}</h5>
                            </td>
                            <td class="p-2 text-center">
                                <h5 class="">@money($item->order_total, $item->currency_code, true)</h5>
                            </td>
                        </tr>
                    @endif
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>
@stop
