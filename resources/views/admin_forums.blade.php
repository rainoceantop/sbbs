@extends('layouts.app')

@section('title', '板块管理')

@section('link')
@endsection

@section('content')

<div class="row">
    @include('inc.card-center')
    <section class="col-lg-10 d-lg-block right">
        <div class="card">

            <!-- 新建板块区域 -->
            <div class="card-header d-flex justify-content-between">
                <!-- 左边新建板块 -->
                <div>
                    <a href="/" @if(!Auth::user()->is_super_admin) class="btn btn-sm disabled" @endif data-toggle="modal" data-target="#new-forum-form-modal">+ 新建板块</a>
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
                                        <div class="form-group">
                                            <textarea name="description" class="form-control" rows="5" placeholder="板块描述"></textarea>
                                        </div>
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">关闭</button>
                                        <button type="submit" class="btn btn-primary" id="new-forum-submit-button">新建</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 右边删除板块 -->
                <div>
                    <a href="/" @if(!Auth::user()->is_super_admin) class="btn btn-sm text-danger disabled" @else class="text-danger" @endif data-toggle="modal" data-target="#delete-forum-form-modal">- 删除板块</a>
                    <!-- Modal -->
                    <div class="modal fade" id="delete-forum-form-modal" tabindex="-1" role="dialog">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">删除板块</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form id="delete-forum-form" action="{{ route('forum.destroy') }}" method="POST">
                                        @csrf
                                        @method('delete')
                                        <div class="form-group">
                                            @foreach($forums as $forum)
                                            <div class="custom-control custom-checkbox custom-control-inline">
                                                <input type="checkbox" class="custom-control-input" name="forums[]" id="forum-{{ $forum->id }}" value="{{ $forum->id }}">
                                                <label class="custom-control-label" for="forum-{{ $forum->id }}">{{ $forum->name }}</label>
                                            </div>
                                            @endforeach
                                        </div>
                                        <hr>
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">关闭</button>
                                        <button type="button" class="btn btn-danger" id="delete-forum-submit-button">删除</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 板块内容展示区 -->
            <div class="card-body">
                
                <div class="accordion w-100" id="accordionForum">
                    @foreach($forums as $forum)
                        @php
                        $can_edit_forum = !Auth::user()->is_super_admin && !in_array(Auth::user()->id, array_column($forum->administrators()->get()->toArray(), 'id'))
                        @endphp
                        <div class="card">

                            <!-- 板块标题展示区域 -->
                            <div class="card-header  text-center" id="forum{{ $forum->id }}">
                                <h5 class="mb-0">
                                    <button class="btn btn-link @if($can_edit_forum) disabled @endif" type="button" data-toggle="collapse" data-target="#collapse{{ $forum->id }}" aria-controls="collapse{{ $forum->id }}">
                                    {{ $forum->name }}
                                    </button>
                                    <a href="/" data-toggle="modal" data-target="#edit-forum-form-modal-{{ $forum->id }}" title="编辑" class="btn text-success  @if($can_edit_forum) disabled @endif"><i class="fas fa-pen-square"></i></a>
                                
                                    <!-- Modal -->
                                    <div class="modal fade" id="edit-forum-form-modal-{{ $forum->id }}" tabindex="-1" role="dialog">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">{{ $forum->name }}：编辑板块</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <form id="edit-forum-form" action="{{ route('forum.update') }}" method="POST">
                                                        @csrf
                                                        @method('put')
                                                        <input type="hidden" name="forum_id" value="{{ $forum->id }}">
                                                        <div class="form-group">
                                                            <input type="text" name="name" class="form-control" placeholder="板块名称" value="{{ $forum->name }}" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <textarea name="description" class="form-control" rows="5" placeholder="板块描述">{{ $forum->description }}</textarea>
                                                        </div>
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">关闭</button>
                                                        <button type="submit" class="btn btn-primary" id="new-forum-submit-button">编辑</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </h5>
                            </div>

                            <!-- 板块内容管理区域 -->
                            <div id="collapse{{ $forum->id }}" class="collapse" aria-labelledby="forum{{ $forum->id }}" data-parent="#accordionForum">
                                <div class="card-body">
                                    <div class="forum-inside-item">

                                        <!-- 一个行开始 -->
                                        <div class="d-flex justify-content-between">
                                            <!-- 一行左边 -->
                                            <div>
                                            标签组：
                                            @foreach($forum['tagGroups'] as $tagGroup)
                                                <a href="/" data-toggle="modal" data-target="#new-tag-form-modal-{{ $tagGroup->id }}">{{ $tagGroup->name }}</a>
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
                                                                    <input type="hidden" name="forum_id" value="{{ $forum->id }}">
                                                                    <input type="hidden" name="group_id" value="{{ $tagGroup->id }}">
                                                                    <div class="form-group">
                                                                        <input type="text" name="tagGroupName" class="form-control" placeholder="标签组名称" value="{{ $tagGroup->name }}" required>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <textarea name="tagNames" rows="8" class="form-control" placeholder="标签编辑域" required>@foreach($tagGroup->tags()->orderBy('identity')->get() as $tag){{  $tag->identity }} | {{ $tag->name }} | {{ $tag->color }}@php echo " ;\n"; @endphp@endforeach</textarea>
                                                                        <small class="text-muted">每一行都是一个标签，最左边是标签的唯一标识，中间是标签名，右边是标签颜色（十六进制，英文单词，rgba均可），用竖杠“|”隔开，末尾加英文分号。格式需严格按照要求。所有标签（不分板块）的唯一标识不能相同，否则会替换掉。如需删除该标识，请前往<a href="{{ route('tag.index') }}">标签管理</a>。设置标签例子：
                                                                            <br>
                                                                            1 | 功能增强 | #12A3BA ;
                                                                            <br>
                                                                            2 | 风格模板 | orange ;
                                                                            <br>
                                                                            3 | 文档教程 | rgba(0, 0, 0, 0.4) ;
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
                                            </div>
                                
                                            <!-- 一行右边 -->
                                            <a href="/" class="ml-3" style="width:15%" data-toggle="modal" data-target="#new-tag-group-form-modal-{{ $forum->id }}">+ 新建标签组</a>
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
                                                                <button type="submit" class="btn btn-primary new-tag-group-submit-button">新建</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <!-- 一行结束 -->

                                        <!-- 一行开始 -->
                                        <div class="d-flex justify-content-between">
                                            <!-- 一行左边 -->
                                            <div>
                                            负责人：
                                            @foreach($forum->administrators as $user)
                                                <a href="{{ route('user.center', [$user->id]) }}">{{ $user->name }}</a>
                                            @endforeach
                                            </div>
                                            <!-- 一行右边 -->
                                            <a href="/" @if(!Auth::user()->is_super_admin) class="ml-3 btn btn-sm disabled" @else class="ml-3" @endif style="width:15%" data-toggle="modal" data-target="#add-forum-admin-form-modal-{{ $forum->id }}">+ 添加/移除负责人</a>
                                            <!-- Modal -->
                                            <div class="modal fade" id="add-forum-admin-form-modal-{{ $forum->id }}" tabindex="-1" role="dialog">
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">{{ $forum->name }}：添加/移除负责人</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form id="add-forum-admin-form" action="{{ route('forum.addAdmin') }}" method="POST">
                                                                @csrf
                                                                <input type="hidden" name="forum_id" value="{{ $forum->id }}">
                                                                <div class="text-danger custom-control-inline"><strong>移除：</strong>
                                                                @foreach($forum->administrators as $user)
                                                                    <!-- 已加入用户 -->
                                                                    <div class="custom-control custom-checkbox custom-control-inline">
                                                                        <input type="checkbox" class="custom-control-input" name="del_users[]" id="user-{{ $user->id }}" value="{{ $user->id }}">
                                                                        <label class="custom-control-label" for="user-{{ $user->id }}">{{ $user->name }}</label>
                                                                    </div>
                                                                @endforeach
                                                                </div>
                                                                <hr>
                                                                <div class="text-success custom-control-inline"><strong>添加：</strong>
                                                                @foreach($forum->notJoinYetUsersId as $user_id)
                                                                    <!-- 获取未加入用户 -->
                                                                    @php $user = App\User::find($user_id) @endphp
                                                                    <div class="custom-control custom-checkbox custom-control-inline">
                                                                        <input type="checkbox" class="custom-control-input" name="add_users[]" id="user-{{ $user->id }}" value="{{ $user->id }}">
                                                                        <label class="custom-control-label" for="user-{{ $user->id }}">{{ $user->name }}</label>
                                                                    </div>
                                                                @endforeach
                                                                </div>
                                                                <hr>
                                                                <button type="submit" class="btn btn-block btn-primary">执行</button>
                                                            </form>
                                                        </div>
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
    </section>
</div>
@endsection

@section('script')
<script>
$(function(){
    const deleteForumSubmitButton = $('#delete-forum-submit-button')
    const newTagGroupForms = $('.new-tag-group-form')
    const editTagGroupForms = $('.edit-tag-group-form')
    const newTagGroupSubmitButtons = $('.new-tag-group-submit-button')
    const editTagGroupSubmitButtons = $('.edit-tag-group-submit-button')

    // 板块删除相关dom
    const deleteTagGroupSubmitButtons = $('.delete-tag-group-submit-button')

    // 删除板块按钮点击事件
    deleteForumSubmitButton.on('click', function(){
        if(confirm(`确定删除所选的板块吗？请注意，删除后所删板块下的所有帖子都会删除！`)){
            $(this).parents('form').submit()
        }
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