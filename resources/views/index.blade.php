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
<form action="/" method="get">
    <div class="input-group mt-3">
    <input type="text" name="searchInfo" class="form-control" placeholder="全站搜索">
    <div class="input-group-append">
        <span class="input-group-text"><i class="fas fa-search"></i></span>
    </div>
</form>

</div>
@endsection