@extends('layouts.app')

@section('title', $thread->title)

@section('link')
@endsection

@section('main')
<!-- 页面导航 -->
<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item active" aria-current="page"><a href="/"><i class="fas fa-home"></i></a></li>
    <li class="breadcrumb-item active" aria-current="page"><a href="{{ route('forum.show', [$thread->forum->id]) }}">{{ $thread->forum->name }}</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ $thread->title }}</li>
  </ol>
</nav>
<!-- thread内容 -->
<div class="card card-thread mb-3">
    <div class="card-body">
        <section class="thread-title">
            <img src="{{ asset('imgs/user.jpeg') }}" class="user-img-4 mr-3">
            <div class="thread-intro">
                <div class="thread-title-tags">
                    <h4 class="break-all">{{ $thread->title }}</h4>
                    @foreach($tags as $tag)
                    <span class="tag" @php echo "style='background-color:$tag->color'"; @endphp><a href="{{ route('forum.show', [$tag->group->forum_id]) }}?tagids={{ $tag->identity }}">{{ $tag->name }}</a></span>
                    @endforeach
                </div>
                <div class="d-flex small">
                    <span class="username">
                        <a href="user-33.htm" class="text-muted font-weight-bold"><i class="fas fa-pencil-alt"></i> 卡西莫多</a>
                    </span>
                    <span class="date text-grey ml-2"><i class="fas fa-clock"></i> {{ $thread->created_at->diffForHumans() }}</span>
                    <span class="text-grey ml-2"><i class="fas fa-eye"></i> 30</span>
                </div>
            </div>
        </section>
        <hr>
        <section class="thread-body">
            <p>{!! $thread->body !!}</p>
        </section>
    </div>
</div>
<!-- 评论回复内容 -->
<div class="card card-replies">
    <div class="card-body">
        <div class="d-flex justify-content-between">
            <strong>评论回复（{{ count($thread->replies) }}）</strong>
        </div>
        <hr>
        <ul class="list-unstyled thread-replies-list">
            <li class="media">
                <a href="" class="mr-3"><img class="user-img-4" src="{{ asset('imgs/user.jpeg') }}"></a>
                <div class="media-body">
                    <div class="d-flex justify-content-between small text-muted">
                        <div>
                            <span class="font-weight-bold">
                                dffds
                            </span>
                            <span class="text-grey ml-2">
                                六天前
                            </span>
                        </div>
                        <div class="text-right text-grey">
                            <a href=""><i class="fas fa-reply"></i></a>
                        </div>
                    </div>
                    <div class="message mt-1 break-all">
                        <div class="media mb-2">
                            <a href="" class="mr-3"><img class="user-img-5" src="{{ asset('imgs/user.jpeg') }}"></a>
                            <div class="media-body">
                                fsdfdsf
                            </div>
                        </div>
                        jhgfjgfj
                    </div>
                </div>
            </li>
        </ul>
    </div>
</div>
@endsection

@section('aside')
@include('inc.card-user')
@endsection

@section('script')
@endsection