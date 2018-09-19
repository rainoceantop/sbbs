@extends('layouts.app')

@section('title', '我的帖子')

@section('link')
@endsection

@section('content')
<div class="row">
    @include('inc.card-center')
    <section class="col-lg-10 d-lg-block right">
        <div class="card mb-3">
            <div class="card-header">
            <ul class="nav nav-pills nav-fill">
                <li class="nav-item">
                    <a class="nav-link active" href="#">我的帖子</a>
                </li>
            </ul>
            </div>
            <div class="card-body card-thread-list">
            @foreach($threads as $thread)
            <section class="thread-item thread-title">
                <img class="user-img-4 mr-3" src="{{ asset('imgs/user.jpeg') }}">
                <div class="thread-intro">
                    <div class="thread-title-tags">
                        <h5 class="break-all"><a href="{{ route('thread.show', [$thread->id]) }}">{{ $thread->title }}</a></h5>
                        @foreach($thread->tags as $tag)
                        <span class="tag" @php echo "style='background-color:$tag->color'" @endphp><a href="{{ route('tag.show', [$tag->id]) }}">{{ $tag->name }}</a></span>
                        @endforeach
                    </div>
                    <div class="d-flex small">
                        <span class="username">
                            <a href="user-33.htm" class="text-muted font-weight-bold">卡西莫多</a>
                        </span>
                        <span class="date text-grey ml-2">{{ $thread->created_at->diffForHumans() }}</span>
                    </div>
                </div>
            </section>
            @endforeach
            </div>
        </div>
        {{ $threads->links() }}
    </section>
</div>
@endsection

@section('script')
@endsection