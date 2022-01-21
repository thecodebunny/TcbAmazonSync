@extends('tcb-amazon-sync::layouts.tcbmaster')

@section('title', trans('general.title.edit', ['type' => trans_choice('general.items', 1)]))

@section('content')
    <div class="nai patyo hrd">
        <div class="card-header tcb-card-header">Amazon</div>
        <div class="card-body">
            <ul class="nav nav-pills nav-justified" id="amazonTab" role="tablist">
                @if ($settings->uk)
                <li class="nav-item">
                    <a class="nav-link active" id="uk-tab" data-toggle="tab" href="#ukAsin" role="tab" aria-controls="home" aria-selected="true">{{trans('tcb-amazon-sync::items.amazon.uk')}}@empty($uk_item) @if($uk_item->otherseller_warning) <span style="background: rgb(158, 1, 1); color: white; padding: 5px" class="fa fa-bug"> </span>@endif @endempty</a>
                </li>
                @endif
                @if ($settings->de)
                <li class="nav-item">
                    <a class="nav-link" id="de-tab" data-toggle="tab" href="#deAsin" role="tab" aria-controls="profile" aria-selected="false">{{trans('tcb-amazon-sync::items.amazon.de')}}</a>
                </li>
                @endif
                @if ($settings->fr)
                <li class="nav-item">
                    <a class="nav-link" id="fr-tab" data-toggle="tab" href="#frAsin" role="tab" aria-controls="messages" aria-selected="false">{{trans('tcb-amazon-sync::items.amazon.fr')}}</a>
                </li>
                @endif
                @if ($settings->it)
                <li class="nav-item">
                    <a class="nav-link" id="it-tab" data-toggle="tab" href="#itAsin" role="tab" aria-controls="settings" aria-selected="false">{{trans('tcb-amazon-sync::items.amazon.it')}}</a>
                </li>
                @endif
                @if ($settings->es)
                <li class="nav-item">
                    <a class="nav-link" id="es-tab" data-toggle="tab" href="#esAsin" role="tab" aria-controls="settings" aria-selected="false">{{trans('tcb-amazon-sync::items.amazon.es')}}</a>
                </li>
                @endif
                @if ($settings->se)
                <li class="nav-item">
                    <a class="nav-link" id="se-tab" data-toggle="tab" href="#seAsin" role="tab" aria-controls="settings" aria-selected="false">{{trans('tcb-amazon-sync::items.amazon.se')}}</a>
                </li>
                @endif
                @if ($settings->nl)
                <li class="nav-item">
                    <a class="nav-link" id="nl-tab" data-toggle="tab" href="#nlAsin" role="tab" aria-controls="settings" aria-selected="false">{{trans('tcb-amazon-sync::items.amazon.nl')}}</a>
                </li>
                @endif
                @if ($settings->pl)
                <li class="nav-item">
                    <a class="nav-link" id="pl-tab" data-toggle="tab" href="#plAsin" role="tab" aria-controls="settings" aria-selected="false">{{trans('tcb-amazon-sync::items.amazon.pl')}}</a>
                </li>
                @endif
            </ul>
            <div class="tab-content" id="pills-tabContent">
                @if ($settings->uk)
                    @if ($amzItem && !empty($amzItem))
                        @include('tcb-amazon-sync::amazon.asins.forms.ukedit')
                    @else
                        @include('tcb-amazon-sync::amazon.asins.forms.ukcreate')
                    @endif
                @endif
            </div>
        </div>

        <div class="card-footer">
        </div>
    </div>
</div>
@endsection