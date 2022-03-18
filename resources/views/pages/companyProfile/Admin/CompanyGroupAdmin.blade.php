@extends('layouts.layout')
@section('title')
   Company Group Admin
@endsection

@section('content')
    <company-group-admin :admins='{!! $admins !!}'></company-group-admin>
@endsection
