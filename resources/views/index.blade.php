@extends('layouts.app')

@section('title', '首页')

@section('main')
@include('inc.threads')
@endsection

@section('aside')
@include('inc.card-intro')
@endsection