@extends('layouts.layout')
@section('title')
    Company Edit Section
@endsection

@section('content')
   <edit-company :company='{!! json_encode($company) !!}'></edit-company>
@endsection
