@extends('layouts.layout')
@section('title')
    Company Admin Menu
@endsection

@section('content')
    <company-admin-menu :id ='{!! json_encode($id) !!}'></company-admin-menu>
@endsection
