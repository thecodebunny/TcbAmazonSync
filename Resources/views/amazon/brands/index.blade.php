@extends('tcb-amazon-sync::layouts.tcbmaster')

@section('title', "Brands")

@section('new_button')
    <a href="{{ route('tcb-amazon-sync.amazon.brands.create') }}" class="btn btn-info btn-sm">{{ trans('tcb-amazon-sync::general.create') }} {{ trans('tcb-amazon-sync::brand.brand') }}</a>
@endsection

@section('content')
<div class="card">
    @if ($brands->count())
        
            <div class="card-header border-bottom-0" :class="[{'bg-gradient-primary': bulk_action.show}]">
                {!! Form::open([
                    'method' => 'GET',
                    'role' => 'form',
                    'class' => 'mb-0'
                ]) !!}
                    <div class="align-items-center" v-if="!bulk_action.show">
                        <x-search-string model="Modules\TcbAmazonSync\Models\Amazon\Brand" />
                    </div>
                {!! Form::close() !!}
            </div>

            <div class="table-responsive">
                <table class="table table-flush table-hover">
                    <thead class="thead-light">
                        <tr class="row table-head-line">
                            <th class="col-sm-2 col-md-3 col-lg-3 col-xl-3 d-none d-sm-block">{{ Form::bulkActionAllGroup() }}</th>
                            <th class="col-xs-3 col-sm-3 col-md-3 col-lg-2 col-xl-3">@sortablelink('name', trans('general.name'), ['filter' => 'active, visible'], ['class' => 'col-aka', 'rel' => 'nofollow'])</th>
                            <th class="col-lg-2 col-xl-2 d-none d-lg-block">{{ trans_choice('tcb-amazon-sync::brand.enabled', 1) }}</th>
                            <th class="col-lg-2 col-xl-2 text-center d-none d-md-block">{{ trans('tcb-amazon-sync::brand.defaultBrand') }}</th>
                            <th class="col-xs-2 col-sm-2 col-md-1 col-lg-1 col-xl-1 text-center"><a>{{ trans('general.actions') }}</a></th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($brands as $brand)
                        <tr class="row align-items-center border-top-1">
                            <td class="col-sm-2 col-md-3 col-lg-3 col-xl-3 d-none d-sm-block">
                                {{ Form::bulkActionGroup($brand->id, $brand->name) }}
                            </td>
                            <td class="col-xs-3 col-sm-3 col-md-3 col-lg-2 col-xl-3">
                                <a href="{{ route('tcb-amazon-sync.amazon.brand.edit', ['id' => $brand->id]) }}">{{ $brand->name }}</a>
                            </td>
                            <td class="col-lg-2 col-xl-2 d-none d-lg-block">
                                @if($brand->enabled == 1) 
                                    <span class="btn btn-success btn-sm "><i class="fas fa-check-circle"></i></span>
                                @else
                                    <span class="btn btn-danger btn-sm "><i class="fas fa-times-circle"></i></span>
                                @endif
                            </td>
                            <td class="col-lg-2 col-xl-2 text-center d-none d-md-block">
                                @if($brand->default_brand == 1) 
                                    <span class="btn btn-success btn-sm "><i class="fas fa-check-circle"></i></span>
                                @else
                                    <span class="btn btn-danger btn-sm "><i class="fas fa-times-circle"></i></span>
                                @endif
                            </td>
                            <td class="col-xs-1 col-sm-1 col-md-1 col-lg-1 col-xl-1 text-center">
                                <div class="dropdown">
                                    <a class="btn btn-neutral btn-sm text-light items-align-center p-2" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fa fa-ellipsis-h text-muted"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                        <a class="dropdown-item" href="{{ route('tcb-amazon-sync.amazon.brand.edit', $brand->id) }}">{{ trans('general.edit') }}</a>
                                        @permission('create-common-items')
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item" href="{{ route('tcb-amazon-sync.amazon.brand.duplicate', $brand->id) }}">{{ trans('general.duplicate') }}</a>
                                        @endpermission
                                        <div class="dropdown-divider"></div>
                                        <form method="POST">
                                            @csrf
                                            <a id="deleteBrand" style="cursor: pointer" class="dropdown-item" route="{{ route('tcb-amazon-sync.amazon.brand.destroy', $brand->id) }}">{{ trans('tcb-amazon-sync::general.destroy') }}</a>
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
            {{ trans('tcb-amazon-sync::brand.nobrand') }}
        </p>
    @endif
</div>
@stop

