@extends('layouts.admin')

@section('title', trans_choice('tcb-amazon-sync::general.amzcategories', 2))

@section('content')
    <div class="card">
        <div class="card-header border-bottom-0" :class="[{'bg-gradient-primary': bulk_action.show}]">
            <div class="align-categories-center" v-if="!bulk_action.show">
                <x-search-string model="Modules\TcbAmazonSync\Models\Categories" />
            </div>
        </div>
            <div class="table-responsive">
                <table class="table table-flush table-hover">
                    <thead class="thead-light">
                        <tr class="row table-head-line">
                            <th class="col-xs-6 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                                @sortablelink('name', trans('tcb-amazon-sync::general.category.path'), ['filter' => 'active, visible'], ['class' => '', 'rel' => 'nofollow'])
                            </th>
                            <th class="col-xs-3 col-sm-2 col-md-3 col-lg-3 col-xl-3 text-center">{{ trans('tcb-amazon-sync::general.category.rootcat') }}</th>
                            <th class="col-xs-3 col-sm-2 col-md-3 col-lg-3 col-xl-3 text-center">{{ trans('tcb-amazon-sync::general.category.ukid') }}</th>
                            <!--
                            <th class=" text-center">{{ trans('tcb-amazon-sync::general.category.deid') }}</th>
                            <th class=" text-center">{{ trans('tcb-amazon-sync::general.category.frid') }}</th>
                            <th class=" text-center"><a>{{ trans('tcb-amazon-sync::general.category.itid') }}</a></th>
                            <th class=" text-center"><a>{{ trans('tcb-amazon-sync::general.category.esid') }}</a></th>
                            -->
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($categories as $category)
                            <tr class="row align-categories-center border-top-1">
                                <td class="col-xs-6 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                                    {{ $category->node_path }}
                                </td>
                                <td class="col-xs-3 col-sm-2 col-md-3 col-lg-3 col-xl-3 text-center">
                                    {{ $category->root_node }}
                                </td>
                                <td class="col-xs-3 col-sm-2 col-md-3 col-lg-3 col-xl-3 text-center">
                                    {{ $category->uk_node_id }}
                                </td>
                                <!--
                                <td class="">
                                    {{ $category->de_node_id }}
                                </td>
                                <td class="">
                                    {{ $category->fr_node_id }}
                                </td>
                                <td class="">
                                    {{ $category->it_node_id }}
                                </td>
                                <td class="">
                                    {{ $category->es_node_id }}
                                </td>
                                -->
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="card-footer table-action">
                <div class="row align-items-center">
                    {{ $categories->links() }}
                </div>
            </div>
        </div>
@stop
