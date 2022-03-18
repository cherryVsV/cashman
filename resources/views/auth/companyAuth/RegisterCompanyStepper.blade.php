@extends('layouts.layout')
@section('title')
    Company Complete Registration
@endsection

@section('content')
    <company-complete-registration :company='{!! json_encode($company) !!}'></company-complete-registration>
@endsection
