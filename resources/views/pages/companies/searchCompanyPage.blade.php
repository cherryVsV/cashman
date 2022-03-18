@extends('layouts.layout')
@section('title')
    Search Company
@endsection

@section('content')
   <search-company  :auth_user='{!! json_encode($user) !!}'></search-company>
@endsection
