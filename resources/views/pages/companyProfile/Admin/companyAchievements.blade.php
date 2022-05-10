@extends('layouts.layout')
@section('title')
    Company Admin Achievements
@endsection

@section('content')
    <company-admin-achievements :id = '{!! json_encode($id) !!}'></company-admin-achievements>
@endsection
