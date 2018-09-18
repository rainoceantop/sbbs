@extends('layouts.app')

@section('title', '个人中心')

@section('link')
@endsection

@section('content')
<div class="row">
    @include('inc.card-center')
    <section class="col-lg-10 d-lg-block right">
        <div class="card">

            <!-- 新建板块区域 -->
            <div class="card-header">
                <a href="/" class="text-right" data-toggle="modal" data-target="#new-forum-form-modal">+ 新建板块</a>
                <!-- Modal -->
                <div class="modal fade" id="new-forum-form-modal" tabindex="-1" role="dialog">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">新建板块</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form id="new-forum-form" action="{{ route('forum.store') }}" method="POST">
                                    @csrf
                                    <div class="form-group">
                                        <input type="text" name="name" class="form-control" placeholder="板块名称" required>
                                    </div>
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">关闭</button>
                                    <button type="button" class="btn btn-primary" id="new-forum-submit-button">新建</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 板块内容展示区 -->
            <div class="card-body">
                <div class="input-group mb-3">
                    <div class="accordion w-100" id="accordionExample">
                        @foreach($forums as $forum)
                            <div class="card">

                                <!-- 板块标题展示区域 -->
                                <div class="card-header  text-center" id="forum{{ $forum->id }}">
                                    <h5 class="mb-0">
                                        <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapse{{ $forum->id }}" aria-controls="collapse{{ $forum->id }}">
                                        {{ $forum->name }}
                                        </button>
                                    </h5>
                                </div>

                                <!-- 板块内容管理区域 -->
                                <div id="collapse{{ $forum->id }}" class="collapse" aria-labelledby="forum{{ $forum->id }}" data-parent="#accordionExample">
                                    <div class="card-body">
                                        <div class="forum-inside-item">
                                            标签组：
                                            @foreach($forum['tagGroups'] as $tagGroup)
                                                <a href="/" class="text-right" data-toggle="modal" data-target="#new-tag-form-modal-{{ $tagGroup->id }}">{{ $tagGroup->name }}</a>
                                                <!-- Modal -->
                                                <div class="modal fade" id="new-tag-form-modal-{{ $tagGroup->id }}" tabindex="-1" role="dialog">
                                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">编辑标签组</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form class="edit-tag-group-form" action="{{ route('tag.store') }}" method="POST">
                                                                    @csrf
                                                                    <input type="hidden" name="group_id" value="{{ $tagGroup->id }}">
                                                                    <div class="form-group">
                                                                        <input type="text" name="tagGroupName" class="form-control" placeholder="标签组名称" value="{{ $tagGroup->name }}" required>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <textarea name="tagNames" rows="8" class="form-control" placeholder="标签编辑域" required>@foreach($tagGroup->tags as $tag){{  $tag->identity }} , {{ $tag->name }} , {{ $tag->color }}@php echo " ;\n"; @endphp@endforeach</textarea>
                                                                        <small class="text-muted">每一行都是一个标签，左边是标签名，右边是标签颜色，用英文逗号隔开，末尾加英文分号。如：
                                                                            <br>
                                                                            1, 功能增强 , #ffffff ;
                                                                            <br>
                                                                            2, 风格模板 , #23sa21 ;
                                                                        </small>
                                                                    </div>
                                                                    <hr>
                                                                    <button data-group_id="{{ $tagGroup->id }}" data-group_name="{{ $tagGroup->name }}" class="btn btn-danger delete-tag-group-submit-button">删除</button>
                                                                    <span class="float-right">
                                                                        <button type="button" class="btn btn-secondary edit-tag-group-close-button" data-dismiss="modal">关闭</button>
                                                                        <button type="button" class="btn btn-primary edit-tag-group-submit-button">编辑</button>
                                                                    </span>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                &nbsp;
                                            @endforeach

                                            <!-- 右边新建标签组 -->
                                            <a href="/" class="float-right" data-toggle="modal" data-target="#new-tag-group-form-modal-{{ $forum->id }}">+ 新建标签组</a>
                                            <!-- Modal -->
                                            <div class="modal fade" id="new-tag-group-form-modal-{{ $forum->id }}" tabindex="-1" role="dialog">
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">{{ $forum->name }}：新建标签组</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form id="new-tag-group-form" action="{{ route('tagGroup.store') }}" method="POST">
                                                                @csrf
                                                                <input type="hidden" name="forum_id" value="{{ $forum->id }}">
                                                                <div class="form-group">
                                                                    <input type="text" name="name" class="form-control" placeholder="标签组名称" required>
                                                                </div>
                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">关闭</button>
                                                                <button type="button" class="btn btn-primary new-tag-group-submit-button">新建</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@section('script')
<script>
$(function(){
    let newForumForm = $('#new-forum-form')
    let newTagGroupForms = $('.new-tag-group-form')
    let editTagGroupForms = $('.edit-tag-group-form')
    let newForumSubmitButton = $('#new-forum-submit-button')
    let newTagGroupSubmitButtons = $('.new-tag-group-submit-button')
    let editTagGroupSubmitButtons = $('.edit-tag-group-submit-button')
    let deleteTagGroupSubmitButtons = $('.delete-tag-group-submit-button')

    // 新建板块按钮点击事件
    newForumSubmitButton.on('click', function(){
        newForumForm.submit()
    })

    //新建标签组按钮点击事件
    newTagGroupSubmitButtons.each(function(){
        $(this).on('click', function(){
            $(this).parents('form').submit()
        })
    })

    //编辑标签组标签按钮点击事件
    editTagGroupSubmitButtons.each(function(){
        $(this).on('click', function(){
            $(this).parents('form').submit()
        })
    })

    //删除标签组标签按钮点击事件
    deleteTagGroupSubmitButtons.each(function(){
        $(this).on('click', function(){
            let group_id = $(this).data('group_id')
            let group_name = $(this).data('group_name')
            if(confirm(`确定删除标签组：${group_name}吗？`)){
                $.ajax({
                    url: 'tagGroup/' + group_id,
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    method: 'delete',
                    success: function(msg){
                        alert('删除成功')
                        window.location.reload()
                    }
                })
            }
        })
    })

})
</script>
@endsection