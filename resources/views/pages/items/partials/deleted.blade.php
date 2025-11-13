@extends('layouts.app')
@section('title')
    {{__('Items.deleted')}}
@endsection
@section('subTitle')
    {{ __('Items.deleted') }}
@endsection
@section('breadcrumb')
    {{ __('Items') }}
@endsection
@section('breadcrumbActive')
    {{ __('Deleted') }}
@endsection
@section('content')
deleted items
@endsection