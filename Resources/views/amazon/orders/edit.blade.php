@extends('tcb-amazon-sync::layouts.tcbmaster')

@section('title', trans('tcb-amazon-sync::orders.amzorder'))

@section('new_button')
    @if($order->order_status !== 'Shipped')
        <a href="" class="btn btn-danger btn-sm">
            {{ trans('tcb-amazon-sync::orders.ship') }}
        </a>
    @endif
    <a href="" class="btn btn-warning btn-sm">
        {{ trans('tcb-amazon-sync::orders.edit') }}
    </a>
@endsection