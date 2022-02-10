@extends('tcb-amazon-sync::layouts.tcbmaster')

@section('title', trans_choice('general.items', 2))

@push('css')
    <link rel="stylesheet" href="{{ asset('modules/TcbAmazonSync/Resources/assets/css/tcb.css?v=' . module_version('tcb-amazon-sync')) }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('modules/TcbAmazonSync/Resources/assets/css/items.css?v=' . module_version('tcb-amazon-sync')) }}" type="text/css">
@endpush

@section('content')
    @if ($count)
        <div class="card">
            <div class="card-header border-bottom-0" :class="[{'bg-gradient-primary': bulk_action.show}]">
                <h3>Total {{ $count }} Items</h3>
            </div>

            <div class="table-responsive">
                <table id="itemsDataTable" class="table table-flush table-hover" data-route="{{ route('tcb-amazon-sync.amazon.items.datatables', $country) }}">
                    <thead class="thead-light">
                        <tr>
                            <th>ID</th>
                            <th>{{ trans('tcb-amazon-sync::items.title') }}</th>
                            <th>{{ trans('tcb-amazon-sync::items.sku') }}</th>
                            <th>{{ trans('tcb-amazon-sync::items.asin') }}</th>
                            <th>{{ trans('tcb-amazon-sync::items.warnings.warnings') }}</th>
                            <th>{{ trans('tcb-amazon-sync::items.category') }}</th>
                            <th>{{ trans('tcb-amazon-sync::items.quantity') }}</th>
                            <th>{{ trans('tcb-amazon-sync::items.price') }}</th>
                            <th>{{ trans('tcb-amazon-sync::items.actions') }}</th>
                        </tr>
                    </thead>
                    <tfoot class="thead-light">
                        <tr>
                            <th>ID</th>
                            <th>{{ trans('tcb-amazon-sync::items.title') }}</th>
                            <th>{{ trans('tcb-amazon-sync::items.sku') }}</th>
                            <th>{{ trans('tcb-amazon-sync::items.asin') }}</th>
                            <th>{{ trans('tcb-amazon-sync::items.warnings.warnings') }}</th>
                            <th>{{ trans('tcb-amazon-sync::items.category') }}</th>
                            <th>{{ trans('tcb-amazon-sync::items.quantity') }}</th>
                            <th>{{ trans('tcb-amazon-sync::items.price') }}</th>
                            <th>{{ trans('tcb-amazon-sync::items.actions') }}</th>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <div class="card-footer table-action">
                <div class="row align-items-center">
                </div>
            </div>
        </div>
    @endif
@stop
