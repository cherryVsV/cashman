@extends('layouts.layout')
@section('title')
    404 - Not found company
@endsection

@section('content')
    <page-not-found :company='{!! json_encode( $company_url) !!}'></page-not-found>
@endsection
