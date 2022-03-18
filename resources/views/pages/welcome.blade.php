@extends('layouts.layout')
@section('title')
    Main Page
@endsection

@section('content')
    <main-page :auth_user='{!! json_encode($profile) !!}'></main-page>
@endsection
