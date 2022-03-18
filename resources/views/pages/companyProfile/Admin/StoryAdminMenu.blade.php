@extends('layouts.layout')
@section('title')
    Story Admin Menu
@endsection

@section('content')
  <story-admin-menu :stories='{!! json_encode($stories) !!}' :news='{!! json_encode($news) !!}'
                    :id = '{!! json_encode($id) !!}'></story-admin-menu>
@endsection
