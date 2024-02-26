@extends('template')

@section('title')
Customer Orders - {{ $customer->name }}
@endsection

@section('content')
    <Customer-Orders :customer_id="{{ $customer->id }}" />
@endsection