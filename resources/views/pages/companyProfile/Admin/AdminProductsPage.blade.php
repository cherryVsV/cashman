@extends('layouts.layout')
@section('title')
    Company Admin Products
@endsection

@section('content')
<company-admin-products :id='{!! json_encode($id) !!}'></company-admin-products>
@endsection
