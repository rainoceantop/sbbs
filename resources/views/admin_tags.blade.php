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
                        <th scope="col">所属板块</th>
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
                            <td>{{ $tag->group->forum->name }}</td>
                            <td>
                                <a href="#" data-toggle="modal" data-target="#show-tag-threads-modal-{{ $tag->identity }}">{{ count($tag->threads) }}</a>
                                <div class="modal fade" id="show-tag-threads-modal-{{ $tag->identity }}" aria-labelledby="myLargeModalLabel" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            包含标签：“{{ $tag->name }}”的帖子
                                        </div>
                                        <div class="modal-body">
                                            <table class="table">
                                            <thead>
                                                <tr>
                                                <th scope="col">id</th>
                                                <th scope="col">标题</th>
                                                <th scope="col">发表于</th>
                                                <th scope="col">负责人</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($tag->threads as $thread)
                                                <tr>
                                                <th scope="row">{{ $thread->id }}</th>
                                                <td><a href="{{ route('thread.show', [$thread->id]) }}">{{ $thread->title }}</a></td>
                                                <td>{{ $thread->created_at->diffForHumans() }}</td>
                                                <td><a href="{{ route('user.center', [$thread->user->id]) }}">{{ $thread->user->name }}</a></td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                </div>
                            </td>
                            <td><a href="javascript:void(0)" class="text-danger tag-delete-button @if( !Auth::user()->is_super_admin && !in_array(Auth::user()->id, array_column($tag->forum->administrators()->get()->toArray(), 'id'))) btn btn-sm disabled @endif" data-tid="{{ $tag->identity }}" data-tname="{{ $tag->name }}">删除</a></td>
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
<script>
$(function(){
    let tagDeleteButton = $('.tag-delete-button')

    tagDeleteButton.each(function(){
        let currentButton = $(this)
        // 标签删除按钮点击事件
        currentButton.on('click', function(){
            if(confirm(`确定删除标签：${currentButton.data('tname')}吗？`)){
                let tid = $(this).data('tid')
                $.ajax({
                    url: "/tag/"+tid,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    method: 'delete',
                    success: function(response){
                        currentButton.parents('tr').hide()
                    }
                })
            }
        })
    })
})
</script>
@endsection