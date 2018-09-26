@extends('layouts.app')

@section('title', '首页')

@section('main')
@include('inc.threads')
@endsection

@section('aside')

@if(!empty($forum))
    @include('inc.card-forum')
    
@else
    @include('inc.card-intro')
@endif

@endsection