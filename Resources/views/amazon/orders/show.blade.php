@extends('tcb-amazon-sync::layouts.tcbmaster')

@section('title', trans('tcb-amazon-sync::orders.amzorder'))

@section('new_button')
    @if($order->order_status !== 'Shipped')
        <a data-toggle="modal" data-target="#confirmShipment" class="btn btn-danger btn-sm text-white">
            {{ trans('tcb-amazon-sync::orders.ship') }}
        </a>
    @endif
    <a href="{{ route('tcb-amazon-sync.amazon.orders.index') }}" class="btn btn-warning btn-sm">
        {{ trans('tcb-amazon-sync::orders.allorders') }}
    </a>
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
    <div class="shadow row bg-default rounded mb-4" style="font-size: inherit !important;">
        <div class="col-4 text-white col-lg-5 pt-3">
            {{ trans('tcb-amazon-sync::orders.amzordernumber') }}
            <br>
            <strong>
                <span class="float-left mwpx-200 transaction-head-text">
                    <a>
                       # {{ $order->amazon_order_id }}
                    </a>
                </span>
            </strong> 
            <br>
            <br>
        </div>
        <div class="col-4 text-white col-lg-5 pt-3">
            @if($order->order_status == 'Shipped')
                {{ trans('tcb-amazon-sync::orders.trackingids') }}
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
                                            <img src="{{ $item->image }}" width="80">
                                        </td>
                                        <td class="p-2 text-center">
                                            <a class="">{{ $item->quantity }}</a>
                                        </td>
                                        <td class="p-2 text-center">
                                            <a class="" href="{{ route('tcb-amazon-sync.items.show', [$item->amazon_item_id, $item->country]) }}">{{ $item->sku }}</a>
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

    <!-- Order Shipping Confirmation Modal -->
    <div id="confirmShipment" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="confirmShipment" aria-hidden="true">
        <div class="modal-dialog modal- modal-dialog-centered modal-m" role="document">
            <div class="modal-content">
                <div class="modal-body p-0">
                    <div class="card bg-secondary border-0 mb-0 p-3">
                        <div class="card-header border-bottom text-center">
                            <h3>{{ trans('tcb-amazon-sync::orders.ship') }} | {{ $order->amazon_order_id }}</h3>
                        </div>
                        <div class="card-body">
                            <form data-action="{{ route('tcb-amazon-sync.amazon.orders.confirmshipment',[$order->id]) }}">

                                {!! Form::hidden('company_id', $order->company_id) !!}

                                {!! Form::hidden('country', $order->country) !!}

                                {!! Form::hidden('amzOrderId', $order->amazon_order_id) !!}

                                {!! Form::hidden('id', $order->id) !!}

                                <div class="form-group">
                                    <label for="carrier" class="form-control-label">{{ trans('tcb-amazon-sync::orders.carrier') }}</label>
                                    <select name="carrier" class="form-control tcb-select">
                                        <option value="DPD">Carrier</option>
                                        <option value="DPD">DPD</option>
                                        <option value="DHL">DHL</option>
                                        <option value="UPS">UPS</option>
                                        <option value="GLS">GLS</option>
                                        <option value="Hermes">Hermes</option>
                                        <option value="Self Delivery">Self Delivery</option>
                                        <option value="Deutsche Post">Deutsche Post</option>
                                        <option value="Royoal Mail">Royoal Mail</option>
                                    </select>
                                </div>
    
                                {{ Form::textGroup('tId', trans('tcb-amazon-sync::orders.trackingid'), 'fab fa-id-card', [], '', '') }}
                                
                                {{ Form::textGroup('tId2', trans('tcb-amazon-sync::orders.trackingid2'), 'fab fa-id-card', [], '', 'hidden trackingId2') }}
                                
                                {{ Form::textGroup('tId3', trans('tcb-amazon-sync::orders.trackingid3'), 'fab fa-id-card', [], '', 'hidden trackingId3') }}
                                
                                {{ Form::textGroup('tId4', trans('tcb-amazon-sync::orders.trackingid4'), 'fab fa-id-card', [], '', 'hidden trackingId4') }}
                                
                                {{ Form::textGroup('tId5', trans('tcb-amazon-sync::orders.trackingid5'), 'fab fa-id-card', [], '', 'hidden trackingId5') }}

                            </form>
                            <div id="shipMessage"></div>
                        </div>
                        <div class="card-footer border-top">
                            <button id="confirmAmazonShipment" class="btn btn-lg btn-icon btn-info" data-url="{{ route('tcb-amazon-sync.amazon.orders.confirmshipment',[$order->id]) }}">
                                 <span class="btn-inner--text">{{ trans('tcb-amazon-sync::orders.sendtoamazon') }}</span>
                            </button>
                            <a id="addTrackingIds" class="btn btn-warning btn-sm text-white">
                                {{ trans('tcb-amazon-sync::orders.addtrackingid') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
