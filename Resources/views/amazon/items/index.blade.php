@extends('tcb-amazon-sync::layouts.tcbmaster')

@section('title', trans_choice('general.items', 2))

@push('css')
    <link rel="stylesheet" href="{{ asset('modules/TcbAmazonSync/Resources/assets/css/tcb.css?v=' . module_version('tcb-amazon-sync')) }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('modules/TcbAmazonSync/Resources/assets/css/items.css?v=' . module_version('tcb-amazon-sync')) }}" type="text/css">
@endpush

@section('content')
    @if ($items->count())
        <div class="card">
            <div class="card-header border-bottom-0" :class="[{'bg-gradient-primary': bulk_action.show}]">
                {!! Form::open([
                    'method' => 'GET',
                    'role' => 'form',
                    'class' => 'mb-0'
                ]) !!}
                    <div class="align-items-center" v-if="!bulk_action.show">
                        <x-search-string model="Modules\TcbAmazonSync\Models\Amazon\Item" />
                    </div>
                {!! Form::close() !!}
            </div>

            <div class="table-responsive">
                <table class="table table-flush table-hover">
                    <thead class="thead-light">
                        <tr class="row table-head-line">
                            <th class="col-lg-3 col-xl-3 col-xs-3 col-sm-3 col-md-3">@sortablelink('name', trans('general.name'), ['filter' => 'active, visible'], ['class' => 'col-aka', 'rel' => 'nofollow'])</th>
                            <th class="col-md-2 col-lg-2 col-xl-2 text-right d-none d-md-block">{{ trans('tcb-amazon-sync::items.sku') }}</th>
                            <th class="col-lg-2 col-xl-2 d-none d-md-block">{{ trans('tcb-amazon-sync::general.warnings') }}</th>
                            <th class="col-lg-2 col-xl-2 d-none d-lg-block">{{ trans_choice('general.categories', 1) }}</th>
                            <th class="col-lg-1 col-xl-1 d-none d-md-block">{{ trans('tcb-amazon-sync::general.stock') }}</th>
                            <th class="col-lg-1 col-xl-1 text-right d-none d-lg-block">{{ trans('tcb-amazon-sync::items.price') }}</th>
                            <th class="col-xs-1 col-sm-1 col-md-1 col-lg-1 col-xl-1"><a>{{ trans('general.actions') }}</a></th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($items as $item)
                            <tr class="row align-items-center border-top-1">
                                <td class="col-xs-3 col-sm-3 col-md-3 col-lg-2 col-xl-3 py-2">
                                    <img src="{{ $item->main_picture ? asset('/public/' . $item->main_picture) : asset('/public/tcb-amazon-sync/img/no-image.png')  }}" class="avatar image-style p-1 mr-3 item-img hidden-md col-aka tcb-image" alt="{{ \Illuminate\Support\Str::limit($item->title, 30, $end='...') }}">
                                        <a href="{{ route('tcb-amazon-sync.items.show', [$item->id, 'Uk']) }}">{{ \Illuminate\Support\Str::limit($item->title, 30, $end='...') }}</a>
                                </td>
                                <td class="col-md-2 col-lg-2 col-xl-2 d-none d-md-block">
                                    {{ $item->sku }}
                                </td>
                                <td class="col-lg-2 col-xl-2 d-none d-lg-block">
                                    @if($item->otherseller_warning) <span style="color: #FFF !important" class="btn btn-danger btn-sm text-white" data-toggle="tooltip" data-placement="top" title="{{ trans('tcb-amazon-sync::items.warnings.otherseller') }}"><i class="fas fa-store"></i></span> @endif
                                    @if(strlen($item->title) < 150) <span style="color: #FFF !important" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="{{ trans('tcb-amazon-sync::items.warnings.shorttitle') }}"><i class="fas fa-heading"></i></span> @endif
                                    @if(!$item->bullet_point_5) <span style="color: #FFF !important" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="{{ trans('tcb-amazon-sync::items.warnings.bulletpoint') }}"><i class="fas fa-list-ul"></i></span> @endif
                                    @if(!$item->picture_6) <span style="color: #FFF !important" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="{{ trans('tcb-amazon-sync::items.warnings.images') }}"><i class="fas fa-images"></i></span> @endif
                                </td>
                                <td class="col-lg-2 col-xl-2 d-none d-lg-block">
                                    {{ $item->category_id }}
                                </td>
                                <td class="col-lg-1 col-xl-1 text-left d-none d-md-block">
                                    {{ $item->quantity }}
                                </td>
                                <td class="col-md-1 col-lg-1 col-xl-1 text-right d-none d-md-block">
                                    @if ($item->sale_price ) <span style="text-decoration: line-through;"> @endif{{ $item->price }} @if ($item->sale_price ) </span> / {{ $item->sale_price }} @endif
                                </td>
                                <td class="col-xs-1 col-sm-1 col-md-1 col-lg-1 col-xl-1">
                                    <div class="dropdown">
                                        <a class="btn btn-neutral btn-sm text-light items-align-center p-2" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fa fa-ellipsis-h text-muted"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                            <a class="dropdown-item" href="{{ route('tcb-amazon-sync.amazon.asinsetup', $item->item_id) }}">{{ trans('general.edit') }}</a>
                                            <div class="dropdown-divider"></div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="card-footer table-action">
                <div class="row align-items-center">
                    {{ $items->links() }}
                </div>
            </div>
        </div>
    @endif
@stop
