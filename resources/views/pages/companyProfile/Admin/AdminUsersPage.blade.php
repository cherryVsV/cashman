@extends('layouts.layout')
@section('title')
    Company Admin Users
@endsection

@section('content')
    <company-admin-users :users = '{!! json_encode($users) !!}'></company-admin-users>
@endsection
