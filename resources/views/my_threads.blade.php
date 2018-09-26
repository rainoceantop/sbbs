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
                    <span class="nav-link active">@if($user->id == Auth::user()->id) 我的帖子 @else {{$user->name}}的帖子 @endif</span>
                </li>
            </ul>
            </div>
            <div class="card-body card-thread-list">
            @foreach($threads as $thread)
            <section class="thread-item thread-title">
                <a href="{{ route('user.center', $thread->user_id) }}"><img class="user-img-4 mr-3" src="{{ asset('imgs/user.jpeg') }}"></a>
                <div class="thread-intro w-100">
                    <div class="thread-title-tags">
                        <h5 class="break-all"><a href="{{ route('thread.show', [$thread->id]) }}">{{ $thread->title }}</a>
                        @foreach($thread->tags as $tag)
                        <span class="tag" @php echo "style='background-color:$tag->color'" @endphp><a href="{{ route('forum.show', [$thread->forum_id]) }}?tagids={{ $tag->identity }}">{{ $tag->name }}</a></span>
                        @endforeach
                        </h5>
                    </div>
                    <div class="d-flex small justify-content-between">
                        <!-- 左 -->
                        <div>
                            <span class="username">
                                <a href="{{ route('user.center', $thread->user_id) }}" class="text-muted">{{ $thread->user->name }}</a>
                            </span>
                            <span class="date ml-2">{{ $thread->created_at->diffForHumans() }}</span>
                            @if( $thread->replies()->count() > 0 )
                            &nbsp;<i class="fas fa-arrow-left ml-2"></i>&nbsp;
                            <span class="ml-2">{{ $thread->replies()->orderBy('created_at', 'desc')->first()->user->name }}</span>
                            <span class="ml-2">{{ $thread->replies()->orderBy('created_at', 'desc')->first()->created_at->diffForHumans() }}</span>
                            @endif
                        </div>
                        <!-- 右 -->
                        <div>
                        <i class="far fa-comment"></i>&nbsp;{{ $thread->replies()->count() }}
                        </div>
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