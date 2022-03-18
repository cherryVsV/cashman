@extends('layouts.layout')
@section('title')
    Company Admin Advertisement
@endsection

@section('content')
    <company-admin-advertisement :id = '{!! json_encode($id) !!}'></company-admin-advertisement>
@endsection
