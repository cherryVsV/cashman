@extends('layouts.layout')
@section('title')
    News
@endsection

@section('content')
    <news :items ='{!!json_encode($news) !!}'></news>
@endsection
