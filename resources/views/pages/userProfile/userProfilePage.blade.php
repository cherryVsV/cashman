@extends('layouts.layout')
@section('title')
    User Profile
@endsection

@section('content')
    <user-page :auth_user='{!! json_encode($profile) !!}' :companies = '{!! json_encode($company) !!}'
    :news='{!! json_encode($news) !!}'  :stories='{!! json_encode($stories) !!}'
    :cashbacks='{!! json_encode($cashback) !!}' :actions='{!! json_encode($actions) !!}'
               :achievements='{!! json_encode($achievements) !!}'></user-page>
@endsection
