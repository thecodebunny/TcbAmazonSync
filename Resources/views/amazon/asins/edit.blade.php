@extends('layouts.admin')

@section('title', trans('general.title.edit', ['type' => trans_choice('general.items', 1)]))

@section('content')
    <div class="card">
        <div class="card-header tcb-card-header">Amazon</div>
        <div class="card-body">
            <ul class="nav nav-pills nav-justified" id="amazonTab" role="tablist">
                @if ($mwsSettings->uk)
                <li class="nav-item">
                    <a class="nav-link active" id="uk-tab" data-toggle="tab" href="#ukAsin" role="tab" aria-controls="home" aria-selected="true">{{trans('tcb-amazon-sync::items.amazon.uk')}}</a>
                </li>
                @endif
                @if ($mwsSettings->de)
                <li class="nav-item">
                    <a class="nav-link" id="de-tab" data-toggle="tab" href="#deAsin" role="tab" aria-controls="profile" aria-selected="false">{{trans('tcb-amazon-sync::items.amazon.de')}}</a>
                </li>
                @endif
                @if ($mwsSettings->fr)
                <li class="nav-item">
                    <a class="nav-link" id="fr-tab" data-toggle="tab" href="#frAsin" role="tab" aria-controls="messages" aria-selected="false">{{trans('tcb-amazon-sync::items.amazon.fr')}}</a>
                </li>
                @endif
                @if ($mwsSettings->it)
                <li class="nav-item">
                    <a class="nav-link" id="it-tab" data-toggle="tab" href="#itAsin" role="tab" aria-controls="settings" aria-selected="false">{{trans('tcb-amazon-sync::items.amazon.it')}}</a>
                </li>
                @endif
                @if ($mwsSettings->es)
                <li class="nav-item">
                    <a class="nav-link" id="es-tab" data-toggle="tab" href="#esAsin" role="tab" aria-controls="settings" aria-selected="false">{{trans('tcb-amazon-sync::items.amazon.es')}}</a>
                </li>
                @endif
                @if ($mwsSettings->se)
                <li class="nav-item">
                    <a class="nav-link" id="se-tab" data-toggle="tab" href="#seAsin" role="tab" aria-controls="settings" aria-selected="false">{{trans('tcb-amazon-sync::items.amazon.se')}}</a>
                </li>
                @endif
                @if ($mwsSettings->nl)
                <li class="nav-item">
                    <a class="nav-link" id="nl-tab" data-toggle="tab" href="#nlAsin" role="tab" aria-controls="settings" aria-selected="false">{{trans('tcb-amazon-sync::items.amazon.nl')}}</a>
                </li>
                @endif
                @if ($mwsSettings->pl)
                <li class="nav-item">
                    <a class="nav-link" id="pl-tab" data-toggle="tab" href="#plAsin" role="tab" aria-controls="settings" aria-selected="false">{{trans('tcb-amazon-sync::items.amazon.pl')}}</a>
                </li>
                @endif
            </ul>
            <div class="tab-content" id="pills-tabContent">
                @if ($mwsSettings->uk)
                    @if ($uk_item && !empty($uk_item))
                        @include('tcb-amazon-sync::amazon.asins.forms.ukedit', ['warehouses', $warehouses])
                    @else
                        @include('tcb-amazon-sync::amazon.asins.forms.ukcreate', ['warehouses', $warehouses])
                    @endif
                @endif
            </div>
        </div>

        <div class="card-footer">
        </div>
    </div>
</div>
@endsection

@push('scripts_start')
<script src="{{ asset('modules/TcbAmazonSync/Resources/assets/js/jquery-ui.min.js?v=' . module_version('tcb-amazon-sync')) }}"></script>
<script src="{{ asset('modules/TcbAmazonSync/Resources/assets/js/fileinput.js?v=' . module_version('tcb-amazon-sync')) }}"></script>
<script src="{{ asset('modules/TcbAmazonSync/Resources/assets/js//plugins/piexif.min.js?v=' . module_version('tcb-amazon-sync')) }}"></script>
<script src="{{ asset('modules/TcbAmazonSync/Resources/assets/js//plugins/sortable.min.js?v=' . module_version('tcb-amazon-sync')) }}"></script>
<script src="{{ asset('modules/TcbAmazonSync/Resources/assets/js//locales/LANG.js?v=' . module_version('tcb-amazon-sync')) }}"></script>
<script src="{{ asset('modules/TcbAmazonSync/Resources/assets/js/app.js?v=' . module_version('tcb-amazon-sync')) }}"></script>
<script src="{{ asset('modules/TcbAmazonSync/Resources/assets/js/item.js?v=' . module_version('tcb-amazon-sync')) }}"></script>
<script src="{{ asset('modules/TcbAmazonSync/Resources/assets/js/forms/saveForm.js?v=' . module_version('tcb-amazon-sync')) }}"></script>
<link rel="stylesheet" href="{{ asset('modules/TcbAmazonSync/Resources/assets/css/uiset.css?v=' . module_version('tcb-amazon-sync')) }}" type="text/css">
<link rel="stylesheet" href="{{ asset('modules/TcbAmazonSync/Resources/assets/css/tcb.css?v=' . module_version('tcb-amazon-sync')) }}" type="text/css">
<link rel="stylesheet" href="{{ asset('modules/TcbAmazonSync/Resources/assets/css/fileinput.css?v=' . module_version('tcb-amazon-sync')) }}" type="text/css">
@endpush