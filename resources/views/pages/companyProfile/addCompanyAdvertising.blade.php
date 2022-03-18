@extends('layouts.layout')
@section('title')
    Add Advertising
@endsection

@section('content')
   <ad-list :id='{!! json_encode($id) !!}'></ad-list>
@endsection
