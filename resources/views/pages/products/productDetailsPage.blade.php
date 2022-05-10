@extends('layouts.layout')
@section('title')
    Product
@endsection

@section('content')
    <product-detail :item='{!! json_encode($product) !!}'
                 :company ='{!! json_encode($company) !!}'></product-detail>
@endsection
