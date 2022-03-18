@extends('layouts.layout')
@section('title')
    Achievements
@endsection

@section('content')
    <achievement-detail :achievement='{!! json_encode($achievement) !!}'></achievement-detail>
@endsection
