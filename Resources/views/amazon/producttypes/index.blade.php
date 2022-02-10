@extends('tcb-amazon-sync::layouts.tcbmaster')

@section('title', trans_choice('tcb-amazon-sync::general.pttypes', 2))

@section('content')
    <div class="card">
        <div class="card-header row border-bottom-0" :class="[{'bg-gradient-primary': bulk_action.show}]">
            <div class="col-md-9">
                <h3>{{ trans('tcb-amazon-sync::general.ptwarning') }}</h3>
            </div>
            <div class="col-md-3">
                <button id="uploadAmazonItem" class="btn btn-sm btn-icon btn-info" data-url="{{ route('tcb-amazon-sync.amazon.getProductTypes') }}">
                    <span class="btn-inner--text">{{ trans('tcb-amazon-sync::general.updatepts') }}</span>
                </button>
            </div>
        </div>

        <div class="table-responsive">
            <table id="ptDataTable" class="table table-flush table-hover" data-route="{{ route('tcb-amazon-sync.amazon.producttype.datatables') }}">
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
@stop