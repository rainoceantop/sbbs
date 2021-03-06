@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    @if(!$admin_register)
        @include('inc.card-center')
    @endif
    <div class="col-lg-10 d-lg-block right">
        <div class="card">
            <div class="card-header">
                <ul class="nav nav-pills nav-fill">
                    <li class="nav-item">
                        <span class="nav-link active">@if($admin_register) {{ __('超级管理员注册') }} @else {{ __('用户注册') }} @endif</span>
                    </li>
                </ul>
            </div>

            <div class="card-body">
                <form method="POST" action="/register">
                    @csrf
                    @if($admin_register)
                        <input type="hidden" name="is_super_admin" value="1">
                    @else
                        <input type="hidden" name="is_super_admin" value="0">
                    @endif
                    <div class="form-group">
                        <label for="name" class="col-form-label text-md-right">{{ __('名称') }}</label>
                        <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required autofocus>
                        @if ($errors->has('name'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('name') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="email" class="col-form-label text-md-right">{{ __('帐号') }}</label>                           
                        <input id="email" type="text" class="form-control{{ $errors->has('username') ? ' is-invalid' : '' }}" name="username" value="{{ old('username') }}" required>
                        @if ($errors->has('username'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('username') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="password" class="col-form-label text-md-right">{{ __('密码') }}</label>
                        <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>
                        @if ($errors->has('password'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="password-confirm" class="col-form-label text-md-right">{{ __('确认密码') }}</label>
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-success btn-block">
                            {{ __('注册') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
