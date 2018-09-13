@extends('layouts.app')

@section('link')
<link rel="stylesheet" href="{{ asset('editor.md/css/editormd.min.css') }}" />
@endsection

@section('content')
<div class="row">
    <div class="col-md-10 mx-auto">
        <div class="card">
            <div class="card-header">
                发表帖子
            </div>
            <div class="card-body">
                <form action="{{ route('thread.store') }}" method="POST">
                    <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                    <div class="form-group">
                        <input type="text" class="form-control" name="title" placeholder="标题">
                    </div>
                    <div id="editormd" class="form-control">
                        <textarea style="display:none;">### Hello Editor.md !</textarea>
                    </div>
                    <button class="btn btn-primary btn-block" type="submit">发表帖子</button>
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
            path : "{{ asset('editor.md/lib/') }}" // Autoload modules mode, codemirror, marked... dependents libs path
        });

        /*
        // or
        var editor = editormd({
            id   : "editormd",
            path : "../lib/"
        });
        */
    });
</script>
@endsection