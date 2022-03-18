@extends('layouts.layout')
@section('title')
    Settings Page
@endsection

@section('content')
    <user-settings :user='{!! json_encode($user) !!}'></user-settings>
@endsection
