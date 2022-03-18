@extends('layouts.layout')
@section('title')
    Your Friends
@endsection

@section('content')
    <user-friends :friends='{!! json_encode($friends) !!}'></user-friends>
@endsection
