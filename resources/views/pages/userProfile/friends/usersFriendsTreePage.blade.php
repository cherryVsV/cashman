@extends('layouts.layout')
@section('title')
    Your Referrals
@endsection

@section('content')
    <users-friends-tree :tree-data='{!!json_encode($treeData) !!}'
                        :id='{!!json_encode($id) !!}'
                        :company='{!!json_encode($company) !!}'></users-friends-tree>
@endsection
