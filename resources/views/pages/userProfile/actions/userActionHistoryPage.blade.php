@extends('layouts.layout')
@section('title')
    History Action
@endsection

@section('content')
    <history :id={!! json_encode($id) !!}></history>
@endsection
