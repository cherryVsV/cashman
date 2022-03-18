@extends('layouts.layout')
@section('title')
   Продолжение регистрации
@endsection
@section('content')
    <user-register-stepper :email='{!! json_encode($email) !!}' ></user-register-stepper>
@endsection
