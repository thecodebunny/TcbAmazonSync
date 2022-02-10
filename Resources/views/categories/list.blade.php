@extends('tcb-amazon-sync::layouts.tcbmaster')

@section('title', trans_choice('tcb-amazon-sync::general.amzcategories', 2))

@section('content')
    <div class="card">
        <div id="categoriesHeader" class="card-header border-bottom-0" :class="[{'bg-gradient-primary': bulk_action.show}]">
            <div class="align-items-center" v-if="!bulk_action.show">
                <h3>AMAZON CATEGORIES - FIND THE CATEGORY ID HERE</h3>
            </div>
        </div>
            <div class="table-responsive">
                <table id="amzCategories" data-route="{{ route('tcb-amazon-sync.amazon.categories.datatables') }}" class="fresh-table table table-flush dataTable table-hover table-striped" style="width:100%">
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
@stop
