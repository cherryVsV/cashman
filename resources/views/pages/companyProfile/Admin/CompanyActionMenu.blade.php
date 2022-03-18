@extends('layouts.layout')
@section('title')
    Company Action Menu
@endsection

@section('content')
    <company-action-menu :company='{!! json_encode($company) !!}'
                         :admin='{!! json_encode($admin) !!}'></company-action-menu>
@endsection
