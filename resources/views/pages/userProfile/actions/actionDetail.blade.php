@extends('layouts.layout')
@section('title')
    History Action
@endsection

@section('content')
    <history-action-detail :action='{!! json_encode($action) !!}'></history-action-detail>
@endsection
