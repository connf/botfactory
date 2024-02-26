@extends('template')

@section('title')
Order {{ isset($order->bot_name) ? "- ".$order->bot_name : "" }}
@endsection

@section('content')
    <Order :order_id="{{ $order->id }}" />
@endsection