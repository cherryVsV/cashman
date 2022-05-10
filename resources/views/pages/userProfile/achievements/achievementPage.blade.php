@extends('layouts.layout')
@section('title')
    Achievements
@endsection

@section('content')
    <achievement :achievements='{!! json_encode($achievements) !!}'></achievement>
@endsection
