@extends('layouts.layout')
@section('title')
    News
@endsection

@section('content')
    <news-detail :item='{!! json_encode($news) !!}' :items='{!! json_encode($company_news) !!}'
    :company ='{!! json_encode($company) !!}'></news-detail>
@endsection
