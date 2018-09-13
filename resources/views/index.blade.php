@extends('layouts.app')

@section('title', '首页')

@section('main')
<home-page></home-page>
@endsection

@section('aside')
<card-intro></card-intro>
<card-forum></card-forum>
<card-user></card-user>
@endsection