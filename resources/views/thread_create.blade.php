@extends('layouts.app')

@section('link')
<link rel="stylesheet" href="{{ asset('editor.md/css/editormd.min.css') }}" />
@endsection

@section('content')
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<?php
$edit = isset($thread) ? TRUE : FALSE
?>
<div class="row">
    <div class="col-lg-10 mx-auto">
        <div class="card">
            <div class="card-header">
                发表帖子
            </div>
            <div class="card-body">
                <form action="{{ $edit ? route('addThread') : route('updThread') }}" method="POST">
                    @if($edit)
                        @method('PUT')
                        <input type="hidden" name="thread_id" value="{{ $thread->id }}">
                    @endif
                    @auth
                    <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                    @endauth
                    <div class="form-group">
                        <input type="text" class="form-control" name="title" placeholder="标题" value="{{ $edit? $thread->title : '' }}">
                    </div>
                    <div id="editormd" class="form-control">
                        <textarea style="display:none;">{{ $edit? $thread->body : '' }}</textarea>
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
            saveHTMLToTextarea: true
        })
    })
</script>
@endsection