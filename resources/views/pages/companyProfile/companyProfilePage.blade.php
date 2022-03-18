@extends('layouts.layout')
@section('title')
    Company Profile
@endsection

@section('content')
 <company-profile :company = '{!! json_encode($company) !!}' :is-admin = '{!! json_encode($isAdmin) !!}'  :news = '{!! json_encode($news) !!}'
                  :users = '{!! json_encode($users) !!}' :stories = '{!! json_encode($stories) !!}'
                  :user = '{!! json_encode($user) !!}'></company-profile>
@endsection
