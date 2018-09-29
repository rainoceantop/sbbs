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
                    <a class="nav-link" href="{{ route('user.center', [$user->id]) }}">基本资料</a>
                </li>
                @if($user->id == Auth::user()->id)
                <li class="nav-item">
                    <a class="nav-link active" href="{{ route('user.center.password', [$user->id]) }}">密码</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('user.center.avatar', [$user->id]) }}">头像</a>
                </li>
                @endif
            </ul>
            </div>
            <div class="card-body">
                <div class="col-lg-6 mx-auto">
                    @include('inc.message')
                    @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                    @elseif(session('fail'))
                    <div class="alert alert-warning">
                        {{ session('fail') }}
                    </div>
                    @endif
                    <form action="{{ route('user.center.password.set', [$user->id]) }}" method="post">
                        @csrf
                        @method('put')
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                            </div>
                            <input type="password" class="form-control" placeholder="旧密码" name="old_password">
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                            </div>
                            <input type="password" class="form-control" placeholder="新密码" name="new_password">
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                            </div>
                            <input type="password" class="form-control" placeholder="重复新密码" name="confirm_password">
                        </div>
                        <div class="form-group">
                        <button type="submit" class="btn btn-block btn-primary">提交</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@section('script')
@endsection