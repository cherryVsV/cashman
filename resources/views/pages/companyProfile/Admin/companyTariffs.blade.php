@extends('layouts.layout')
@section('title')
    Company Tariffs
@endsection

@section('content')
    <company-tariffs :company='{!! json_encode($company) !!}'
                     :tariffs='{!! json_encode($tariffs) !!}'
                     :intent='{!! json_encode($intent) !!}'
                     :current='{!! json_encode($plan) !!}'></company-tariffs>
@endsection
