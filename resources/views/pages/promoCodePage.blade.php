@extends('layouts.layout')
@section('title')
    Promo Code Page
@endsection

@section('content')
    <promo-code :code='{!! json_encode($data) !!}'
                :user='{!! json_encode($userr) !!}'></promo-code>
@endsection
