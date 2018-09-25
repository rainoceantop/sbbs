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
                    <a class="nav-link active" href="#">基本资料</a>
                </li>
                
                <li class="nav-item">
                    <a class="nav-link" href="#">密码</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">头像</a>
                </li>
            </ul>
            </div>
            <div class="card-body">

            </div>
        </div>
    </section>
</div>
@endsection

@section('script')
@endsection