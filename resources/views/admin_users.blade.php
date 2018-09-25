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
                        <span class="nav-link active">用户管理</span>
                    </li>
                </ul>
            </div>
            <div class="card-body">
                <table class="table table-hover">
                    <thead>
                        <tr>
                        <th scope="col">用户id</th>
                        <th scope="col">名称</th>
                        <th scope="col">帐号</th>
                        <th scope="col">创建于</th>
                        <th scope="col">操作</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($users as $user)
                        <tr>
                            <th scope="row">{{ $user->id }}</th>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->username }}</td>
                            <td>{{ $user->created_at->diffForHumans() }}</td>
                            <td><a class="text-success" href="/"  data-toggle="modal" data-target="#edit-user-form-modal-{{ $user->id }}">修改</a>
                                                    <!-- Modal -->
                        <div class="modal fade" id="edit-user-form-modal-{{ $user->id }}" tabindex="-1" role="dialog">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">{{ $user->name }}：编辑用户</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form id="edit-user-form" action="{{ route('user.update') }}" method="POST">
                                        @csrf
                                        @method('put')
                                        <input type="hidden" name="id" value="{{ $user->id }}">
                                        <div class="form-group">
                                            名称：
                                            <input type="text" name="name" class="form-control" placeholder="名称" value="{{ $user->name }}" required>
                                        </div>
                                        <div class="form-group">
                                            帐号：
                                            <input type="text" name="username" class="form-control" placeholder="帐号" value="{{ $user->username }}" required>
                                        </div>
                                        <div class="form-group">
                                            新密码：
                                            <input type="text" name="password" class="form-control" placeholder="新密码">
                                        </div>
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">关闭</button>
                                        <button type="submit" class="btn btn-success edit-user-submit-button">更新</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        </div>
                            </td>
                        
                        
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