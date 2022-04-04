@extends('tcb-amazon-sync::layouts.tcbmaster')

@section('title', $item->title)

@push('css')
    <link rel="stylesheet" href="{{ asset('modules/TcbAmazonSync/Resources/assets/css/items.css?v=' . module_version('tcb-amazon-sync')) }}" type="text/css">
@endpush

@section('new_button')
    <a href="{{ route('tcb-amazon-sync.amazon.asinsetup', ['item_id' => $item->item_id]) }}" class="btn btn-white btn-sm">{{ trans('general.edit') }} Item</a>
    <a href="{{ route('tcb-amazon-sync.amazon.items.index', [$country]) }}" class="btn btn-info btn-sm">{{ trans('tcb-amazon-sync::items.backtoindex') }}</a>
    @if($item->otherseller_warning)
        <span class="btn btn-warning btn-sm text-white" title="{{ trans('tcb-amazon-sync::items.warnings.otherseller') }}"><i class="fas fa-exclamation-circle"></i> </span>
    @endif
@endsection

@section('content')
<div class="col-xs-12 col-sm-12 col-md-12 align-items-center mb-3">
    <h2 class="d-inline-flex mb-0">
        @if(strlen($item->title) < 150) <span style="color: #FFF !important" class="btn btn-danger btn-sm tcb-warning" data-toggle="tooltip" data-placement="top" title="{{ trans('tcb-amazon-sync::items.warnings.shorttitle') }}"><i class="fas fa-exclamation-circle"></i></span> @endif{{ $item->title }}</h2>
</div>
    <div class="row">
        <div class="col-md-3">
            <div class='card'>
                <div class="card-header border-bottom-0 show-transaction-card-header">
                    <img class="text-sm font-weight-600 img-center tcb-image" src="{{ $item->main_picture ? $item->main_picture : asset('/public/tcb-amazon-sync/img/no-image.png') }}" class="img-thumbnail" height="200" width="200" alt="{{ $item->title }}">
                </div>
            </div>

            <div class="card">
                <div class="card-header with-border">
                    <h3 class="card-title">{{ trans('tcb-amazon-sync::general.information') }}</h3>
                </div>
                <div class="card-header border-bottom-0 show-transaction-card-header">
                    <b class="text-sm font-weight-600">{{ trans('tcb-amazon-sync::items.ean') }}</b>
                    <a class="float-right text-xs">{{ $item->ean }}</a>
                </div>
                <div class="card-header border-bottom-0 show-transaction-card-header">
                    <b class="text-sm font-weight-600">{{ trans('tcb-amazon-sync::items.asin') }}</b>
                    <a class="float-right text-xs">{{ $item->asin }}</a>
                </div>
                <div class="card-header border-bottom-0 show-transaction-card-header">
                    <b class="text-sm font-weight-600">{{ trans('tcb-amazon-sync::items.sku') }}</b>
                    <a class="float-right text-xs">{{ $item->sku }}</a>
                </div>

                <div class="card-footer show-transaction-card-footer">
                    <b class="text-sm font-weight-600">{{ trans('tcb-amazon-sync::items.quantity') }}</b>
                    <a class="float-right text-xs">{{ $item->quantity }}</a>
                </div>

                <div class="card-footer show-transaction-card-footer">
                    <b class="text-sm font-weight-600">{{ trans('items.sales_price') }}</b>
                    <a class="float-right text-xs">{{setting('default.currency')}} {{ $item->price }}</a>
                </div>

                <div class="card-footer show-transaction-card-footer">
                    <b class="text-sm font-weight-600">{{ trans('items.purchase_price') }}</b>
                    <a class="float-right text-xs">{{setting('default.currency')}} {{ $item->price }}</a>
                </div>
            </div>

            <div class="card ">
                <div class="card-header with-border">
                    <h3 class="mb-0">{{ trans('tcb-amazon-sync::items.amazon.marketplaces') }}</h3>
                </div>
                <div class="card-header border-bottom-0 show-transaction-card-header">
                    <b class="text-sm font-weight-600">{{ trans('tcb-amazon-sync::items.amazon.uk') }}</b>
                    <a class="float-right text-xs">
                        @if($item->is_uploaded_uk)
                            <span class="btn btn-success btn-sm "><i class="fas fa-check-circle"></i></span>
                        @else
                            <span class="btn btn-danger btn-sm "><i class="fas fa-times-circle"></i></span>
                        @endif
                    </a>
                </div>
                <div class="card-header border-bottom-0 show-transaction-card-header">
                    <b class="text-sm font-weight-600">{{ trans('tcb-amazon-sync::items.amazon.de') }}</b>
                    <a class="float-right text-xs">
                        @if($item->is_uploaded_de)
                            <span class="btn btn-success btn-sm "><i class="fas fa-check-circle"></i></span>
                        @else
                            <span class="btn btn-danger btn-sm "><i class="fas fa-times-circle"></i></span>
                        @endif
                    </a>
                </div>
                <div class="card-header border-bottom-0 show-transaction-card-header">
                    <b class="text-sm font-weight-600">{{ trans('tcb-amazon-sync::items.amazon.fr') }}</b>
                    <a class="float-right text-xs">
                        @if($item->is_uploaded_fr)
                            <span class="btn btn-success btn-sm "><i class="fas fa-check-circle"></i></span>
                        @else
                            <span class="btn btn-danger btn-sm "><i class="fas fa-times-circle"></i></span>
                        @endif
                    </a>
                </div>
                <div class="card-header border-bottom-0 show-transaction-card-header">
                    <b class="text-sm font-weight-600">{{ trans('tcb-amazon-sync::items.amazon.it') }}</b>
                    <a class="float-right text-xs">
                        @if($item->is_uploaded_it)
                            <span class="btn btn-success btn-sm "><i class="fas fa-check-circle"></i></span>
                        @else
                            <span class="btn btn-danger btn-sm "><i class="fas fa-times-circle"></i></span>
                        @endif
                    </a>
                </div>
                <div class="card-header border-bottom-0 show-transaction-card-header">
                    <b class="text-sm font-weight-600">{{ trans('tcb-amazon-sync::items.amazon.es') }}</b>
                    <a class="float-right text-xs">
                        @if($item->is_uploaded_es)
                            <span class="btn btn-success btn-sm "><i class="fas fa-check-circle"></i></span>
                        @else
                            <span class="btn btn-danger btn-sm "><i class="fas fa-times-circle"></i></span>
                        @endif
                    </a>
                </div>
                <div class="card-header border-bottom-0 show-transaction-card-header">
                    <b class="text-sm font-weight-600">{{ trans('tcb-amazon-sync::items.amazon.se') }}</b>
                    <a class="float-right text-xs">
                        @if($item->is_uploaded_se)
                            <span class="btn btn-success btn-sm "><i class="fas fa-check-circle"></i></span>
                        @else
                            <span class="btn btn-danger btn-sm "><i class="fas fa-times-circle"></i></span>
                        @endif
                    </a>
                </div>
                <div class="card-header border-bottom-0 show-transaction-card-header">
                    <b class="text-sm font-weight-600">{{ trans('tcb-amazon-sync::items.amazon.nl') }}</b>
                    <a class="float-right text-xs">
                        @if($item->is_uploaded_nl)
                            <span class="btn btn-success btn-sm "><i class="fas fa-check-circle"></i></span>
                        @else
                            <span class="btn btn-danger btn-sm "><i class="fas fa-times-circle"></i></span>
                        @endif
                    </a>
                </div>
                <div class="card-header border-bottom-0 show-transaction-card-header">
                    <b class="text-sm font-weight-600">{{ trans('tcb-amazon-sync::items.amazon.pl') }}</b>
                    <a class="float-right text-xs">
                        @if($item->is_uploaded_pl)
                            <span class="btn btn-success btn-sm "><i class="fas fa-check-circle"></i></span>
                        @else
                            <span class="btn btn-danger btn-sm "><i class="fas fa-times-circle"></i></span>
                        @endif
                    </a>
                </div>
                <div class="card-header border-bottom-0 show-transaction-card-header">
                    <b class="text-sm font-weight-600">{{ trans('tcb-amazon-sync::items.amazon.us') }}</b>
                    <a class="float-right text-xs">
                        @if($item->is_uploaded_us)
                            <span class="btn btn-success btn-sm "><i class="fas fa-check-circle"></i></span>
                        @else
                            <span class="btn btn-danger btn-sm "><i class="fas fa-times-circle"></i></span>
                        @endif
                    </a>
                </div>
                <div class="card-header border-bottom-0 show-transaction-card-header">
                    <b class="text-sm font-weight-600">{{ trans('tcb-amazon-sync::items.amazon.ca') }}</b>
                    <a class="float-right text-xs">
                        @if($item->is_uploaded_ca)
                            <span class="btn btn-success btn-sm "><i class="fas fa-check-circle"></i></span>
                        @else
                            <span class="btn btn-danger btn-sm "><i class="fas fa-times-circle"></i></span>
                        @endif
                    </a>
                </div>
            </div>

            <div class="card ">
                <div class="card-header with-border">
                    <h3 class="mb-0">{{ trans('tcb-amazon-sync::items.attributes') }}</h3>
                </div>
                <div class="card-header border-bottom-0 show-transaction-card-header">
                    <b class="text-sm font-weight-600">{{ trans('tcb-amazon-sync::items.size') }}</b>
                    <a class="float-right text-xs">{{ $item->size }}</a>
                </div>
                <div class="card-header border-bottom-0 show-transaction-card-header">
                    <b class="text-sm font-weight-600">{{ trans('tcb-amazon-sync::items.height') }}</b>
                    <a class="float-right text-xs">{{ $item->height }}</a>
                </div>
                <div class="card-header border-bottom-0 show-transaction-card-header">
                    <b class="text-sm font-weight-600">{{ trans('tcb-amazon-sync::items.length') }}</b>
                    <a class="float-right text-xs">{{ $item->length }}</a>
                </div>
                <div class="card-header border-bottom-0 show-transaction-card-header">
                    <b class="text-sm font-weight-600">{{ trans('tcb-amazon-sync::items.weight') }}</b>
                    <a class="float-right text-xs">{{ $item->weight }}</a>
                </div>
                <div class="card-header border-bottom-0 show-transaction-card-header">
                    <b class="text-sm font-weight-600">{{ trans('tcb-amazon-sync::items.width') }}</b>
                    <a class="float-right text-xs">{{ $item->width }}</a>
                </div>
                <div class="card-header border-bottom-0 show-transaction-card-header">
                    <b class="text-sm font-weight-600">{{ trans('tcb-amazon-sync::items.color') }}</b>
                    <a class="float-right text-xs">{{ $item->color }}</a>
                </div>
                <div class="card-header border-bottom-0 show-transaction-card-header">
                    <b class="text-sm font-weight-600">{{ trans('tcb-amazon-sync::items.material') }}</b>
                    <a class="float-right text-xs">{{ $item->material }}</a>
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <div class="row">
                <div class="col-md-12">
                    <div class="nav-wrapper pt-0">
                        <ul class="nav nav-pills nav-fill flex-column flex-md-row" id="tabs-icons-text" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link mb-sm-3 mb-md-0 active" id="tabs-icons-text-1-tab" data-toggle="tab" href="#overview" role="tab" aria-controls="tabs-icons-text-1" aria-selected="true">
                                    <i class= "mr-2"></i>{{ trans('tcb-amazon-sync::general.overview') }}
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link mb-sm-3 mb-md-0" id="tabs-icons-text-2-tab" data-toggle="tab" href="#reports" role="tab" aria-controls="tabs-icons-text-2" aria-selected="false">
                                    <i class="mr-2"></i>{{ trans_choice('tcb-amazon-sync::items.show.sales', 1) }} <span class="numberorders">{{ $numberOrders }}</span>
                                </a>
                            </li>

                            @if(count($issues))
                            <li class="nav-item">
                                <a class="nav-link mb-sm-3 mb-md-0" id="tabs-icons-text-2-tab" data-toggle="tab" href="#issues" role="tab" aria-controls="tabs-icons-text-2" aria-selected="false">
                                    <i class="mr-2"></i>{{ trans('tcb-amazon-sync::items.issues.issues') }}
                                </a>
                            </li>
                            @endif
                        </ul>
                    </div>

                    <div class="tab-content" id="cutomer-tab-content">
                        <div class="tab-pane tab active" id="overview">
                            <div class="row">
                                <div class="card ">
                                    <div class="card-header with-border">
                                        <h3 class="mb-0">{{ trans('general.description') }}</h3>
                                    </div>
                                    <div class="card-body">
                                        <p class="text-muted">
                                            {{ $item->description }}
                                        </p>
                                    </div>
                                </div>

                                <div class="card ">
                                    <div class="card-header with-border">
                                        @if(! $item->bullet_point_6) <span style="color: #FFF !important" class="btn btn-danger btn-sm tcb-warning" data-toggle="tooltip" data-placement="top" title="{{ trans('tcb-amazon-sync::items.warnings.bulletpoints') }}"><i class="fas fa-exclamation-circle"></i></span> @endif
                                        <h3 class="mb-0">{{ trans('tcb-amazon-sync::items.bulletpoints') }}</h3>
                                    </div>
                                    <div class="card-body">
                                        <ul class="list-group list-group-flush">
                                            <li class="list-group-item">{!! $item->bullet_point_1 !!}</li>
                                            <li class="list-group-item">{!! $item->bullet_point_2 !!}</li>
                                            <li class="list-group-item">{!! $item->bullet_point_3 !!}</li>
                                            <li class="list-group-item">{!! $item->bullet_point_4 !!}</li>
                                            <li class="list-group-item">{!! $item->bullet_point_5 !!}</li>
                                            <li class="list-group-item">{!! $item->bullet_point_6 !!}</li>
                                        </ul>
                                    </div>
                                </div>

                                <div class="card ">
                                    <div class="card-header with-border">
                                        @if(! $item->picture_6) <span style="color: #FFF !important" class="btn btn-danger btn-sm tcb-warning" data-toggle="tooltip" data-placement="top" title="{{ trans('tcb-amazon-sync::items.warnings.bulletpoints') }}"><i class="fas fa-exclamation-circle"></i></span> @endif
                                        <h3 class="mb-0">{{ trans('tcb-amazon-sync::items.images.images') }}</h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <img class="tcb-image image-center mb-3" src="{{ $item->picture_1 ? asset('/public/' . $item->picture_1) : asset('/public/tcb-amazon-sync/img/no-image.png') }}" />
                                            </div>
                                            <div class="col-md-4">
                                                <img class="tcb-image image-center mb-3" src="{{ $item->picture_2 ? asset('/public/' . $item->picture_2) : asset('/public/tcb-amazon-sync/img/no-image.png') }}" />
                                            </div>
                                            <div class="col-md-4">
                                                <img class="tcb-image image-center mb-3" src="{{ $item->picture_3 ? asset('/public/' . $item->picture_3) : asset('/public/tcb-amazon-sync/img/no-image.png') }}" />
                                            </div>
                                            <div class="col-md-4">
                                                <img class="tcb-image image-center mb-3" src="{{ $item->picture_4 ? asset('/public/' . $item->picture_4) : asset('/public/tcb-amazon-sync/img/no-image.png') }}" />
                                            </div>
                                            <div class="col-md-4">
                                                <img class="tcb-image image-center mb-3" src="{{ $item->picture_5 ? asset('/public/' . $item->picture_5) : asset('/public/tcb-amazon-sync/img/no-image.png') }}" />
                                            </div>
                                            <div class="col-md-4">
                                                <img class="tcb-image image-center mb-3" src="{{ $item->picture_6 ? asset('/public/' . $item->picture_6) : asset('/public/tcb-amazon-sync/img/no-image.png') }}" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card tab-pane fade" id="reports">
                            <div class="card">

                                <div class="card-header border-bottom-0">
                                    <div class="row">
                                        <div class="col-12 card-header-search card-header-space">
                                            <span class="table-text hidden-lg card-header-search-text">{{ trans('tcb-amazon-sync::items.show.sales') }}</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="table-responsive">
                                    <table class="table align-items-center table-flush" id="tbl-transactions">
                                        <thead class="thead-light">
                                            <tr class="row table-head-line">
                                                <th class="col-md-2">{{ trans('general.date') }}</th>
                                                <th class="col-md-3">{{ trans_choice('tcb-amazon-sync::items.show.amzorderid', 1) }}</th>
                                                <th class="col-md-2">{{ trans('tcb-amazon-sync::items.show.marketplace') }}</th>
                                                <th class="col-md-2">{{ trans('tcb-amazon-sync::items.show.Status') }}</th>
                                                <th class="col-md-3">{{ trans('tcb-amazon-sync::items.show.ordertotal') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(count($orders))
                                                @foreach($orders as $order)
                                                    <tr class="row">
                                                        <th class="col-md-2">{{ $order->purchase_date }}</th>
                                                        <th class="col-md-3">
                                                            <a href="{{route('tcb-amazon-sync.amazon.orders.show', [$order->id])}}">
                                                                {{ $order->amazon_order_id }}
                                                            </a>
                                                        </th>
                                                        <th class="col-md-2">{{ $order->marketplace }}</th>
                                                        <th class="col-md-2">{{ $order->order_status }}</th>
                                                        <th class="col-md-3">{{ $order->order_total }}</th>
                                                    </tr>
                                                @endforeach
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                                <div class="card-footer table-action">
                                    <div class="row align-items-center">
                                        {{ $orders->links() }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card tab-pane fade" id="issues">
                            <div class="card">

                                <div class="card-header border-bottom-0">
                                    <div class="row">
                                        <div class="col-12 card-header-search card-header-space">
                                            <span class="table-text hidden-lg card-header-search-text">{{ trans('tcb-amazon-sync::items.issues.issues') }}</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="table-responsive">
                                    <table class="table align-items-center table-flush" id="tbl-transactions">
                                        <thead class="thead-light">
                                            <tr class="row table-head-line">
                                                <th class="col-md-2">{{trans('tcb-amazon-sync::items.issues.severity') }}</th>
                                                <th class="col-md-8">{{ trans('tcb-amazon-sync::items.issues.message') }}</th>
                                                <th class="col-md-2">{{ trans('tcb-amazon-sync::items.issues.attributenames') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(count($issues))
                                                @foreach($issues as $issue)
                                                    <tr class="row">
                                                        <th class="col-md-2">{{ $issue->severity }}</th>
                                                        <th class="col-md-8 text-wrap">{{ $issue->message }}</th>
                                                        <th class="col-md-2 text-wrap">{{ $issue->attribute_names }}</th>
                                                    </tr>
                                                @endforeach
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                                <div class="card-footer table-action">
                                    <div class="row align-items-center">
                                        {{ $orders->links() }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <style>
        .header-body .long-texts {display: none !important;}
    </style>
@stop