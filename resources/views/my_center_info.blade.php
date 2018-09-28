@extends('layouts.app')

@section('title', '个人中心')

@section('link')
@endsection

@section('content')
<div class="row">
    @include('inc.card-center')
    <section class="col-lg-10 d-lg-block right">
        <div class="card">
            <div class="card-header">
            <ul class="nav nav-pills nav-fill">
                <li class="nav-item">
                    <a class="nav-link active" href="{{ route('user.center', [$user->id]) }}">基本资料</a>
                </li>
                @if($user->id == Auth::user()->id)
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('user.center.password', [$user->id]) }}">密码</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('user.center.avatar', [$user->id]) }}">头像</a>
                </li>
                @endif
            </ul>
            </div>
            <div class="card-body">
            <div class="row line-height-4">
                <div class="col-md-6">
                    <span>帖子数：{{ $user_threads_count }}</span>
                    <br>
                    <span>精华数：{{ $user_good_threads }}</span>
                </div>
                <div class="col-md-6">
                    <span>用户组：{{ $user_groups }}</span>
                    <br>
                    <span>创建于：{{ $user_created_at }}</span>
                </div>
            </div>
            </div>
        </div>
    </section>
</div>
@endsection

@section('script')
@endsection