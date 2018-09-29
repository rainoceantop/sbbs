@extends('layouts.app')

@section('title', '帖子操作')

@section('link')
<link rel="stylesheet" href="{{ asset('editor.md/css/editormd.min.css') }}" />
@endsection

@section('content')
@php
$edit = isset($thread) ? TRUE : FALSE
@endphp
<div class="row">
    <div class="col-lg-10 mx-auto">
        @include('inc.message')
        <div class="card">
            <div class="card-header">
                发表帖子
            </div>
            <div class="card-body">
                <form action="{{ $edit ? route('thread.update') : route('thread.store') }}" method="POST">
                    @csrf
                    @if($edit)
                        @method('PUT')
                        <input type="hidden" name="thread_id" value="{{ $thread -> id }}">
                    @endif
                    @auth
                    <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                    @endauth
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <label class="input-group-text" for="select-forum">板块</label>
                        </div>
                        <select class="custom-select" name="select-forum" id="select-forum">
                            <!-- 如果没有上次的值，则默认为板块id。如果有上次的值则默认上次的值 -->
                            @foreach($forums as $forum)
                                <option value="{{ $forum->id }}" @if( (empty(old('select-forum'))? ($edit ? $thread->forum_id : $forum_id) : old('select-forum')) == $forum->id ) selected @endif>{{ $forum->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" name="title" placeholder="标题" value="{{ empty(old('title')) ? ($edit? $thread->title : '') : old('title') }}">
                    </div>
                    <div class="form-group select-tags-area">
                    </div>
                    <div id="editormd" class="form-group">
                        <textarea style="display:none;" class="form-control" name="body_md">{{ empty(old('body_md')) ? ($edit? $thread->body_md : '') : old('body_md') }}</textarea>
                    </div>
                    <button class="btn btn-primary btn-block thread-create-button" type="submit">发表帖子</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script src="{{ asset('editor.md/editormd.min.js') }}"></script>
<script type="text/javascript">
    $(function() {
        var editor = editormd("editormd", {
            height: 640,
            syncScrolling: "double",
            emoji: true,
            path : "/editor.md/lib/", // Autoload modules mode, codemirror, marked... dependents libs path
            saveHTMLToTextarea: true,
        })

        let selectForum = $('#select-forum')
        let selectTagsArea = $('.select-tags-area')
        let forum_id = selectForum.val()
        let tagGroups = JSON.parse('@php echo $tagGroups @endphp')
        // 判断是否编辑
        let edit = '@php echo $edit; @endphp'
        // 如果编辑获取原来的标签
        let thread_tags = ('@php echo $edit ? implode("_", array_column($thread->tags->toArray(), "identity")) : "[]" @endphp').split('_')

        // 初始化当前选择板块标签
        getTags(forum_id)
        
        selectForum.on('change', function(){
            forum_id = $(this).val()
            getTags(forum_id)
        })

        function getTags(forum_id){
            let html = ''
            for(let i in tagGroups){
                let tagGroup = tagGroups[i]
                if(tagGroup.forum_id === parseInt(forum_id)){
                    // 标签组展示
                    html += `
                    <p class="text-muted custom-control-inline">
                        ${tagGroups[i].name}&nbsp;:
                    `
                    // 获取标签组的标签
                    let tags = tagGroup.tags
                    for(let i in tags){
                        html += `
                        <div class="custom-control custom-checkbox custom-control-inline">
                            <input type="checkbox" class="custom-control-input" name="tags[]" id="tag-${ tags[i].identity }" ${ $.inArray(String(tags[i].identity), thread_tags) >= 0 ? 'checked' : '' } value=${tags[i].identity}>
                            <label class="custom-control-label" for="tag-${ tags[i].identity }">${tags[i].name}</label>
                        </div>`
                    }
                    html += `</p>`
                }
            }
            selectTagsArea.html(html)
        }
    })
</script>
@endsection