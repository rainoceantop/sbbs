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
                        <span class="nav-link active">标签管理</span>
                    </li>
                </ul>
            </div>
            <div class="card-body">
                <table class="table table-hover">
                    <thead>
                        <tr>
                        <th scope="col">标签标识码</th>
                        <th scope="col">标签名称</th>
                        <th scope="col">所属标签组</th>
                        <th scope="col">帖子数量</th>
                        <th scope="col">操作</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($tags as $tag)
                        <tr>
                            <th scope="row">{{ $tag->identity }}</th>
                            <td>{{ $tag->name }}</td>
                            <td>{{ $tag->group->name }}</td>
                            <td>{{ count($tag->threads) }}</td>
                            <td>删除</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</div>
@endsection

@section('script')
@endsection