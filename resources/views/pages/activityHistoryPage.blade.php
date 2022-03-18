@extends('layouts.layout')
@section('title')
    История активности
@endsection

@section('content')
    <activity-history-page :history='{!! json_encode($history) !!}'></activity-history-page>
@endsection
