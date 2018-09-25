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
            <strong>评论回复（{{ count($replies) }}）</strong>
        </div>
        <hr>
        <ul class="list-unstyled thread-replies-list">
            @foreach($replies as $index => $reply)
            <!-- 单个评论item -->
            <li class="media thread-replies-item">
                <a href="" class="mr-3"><img class="user-img-4" src="{{ asset('imgs/user.jpeg') }}"></a>
                <div class="media-body">
                    <div class="d-flex justify-content-between small text-muted">
                        <div>
                            <span class="font-weight-bold">
                                {{ App\User::find($reply->from_user_id)->name }}
                            </span>
                            <span class="text-grey ml-2">
                                {{ $reply->created_at->diffForHumans() }}
                            </span>
                        </div>
                        <div class="text-right text-grey">
                        @auth
                            <a class="reply-button" data-index="{{ $reply->id }}" data-to_user_id="{{ $reply->from_user_id }}" data-user_name="{{ App\User::find($reply->from_user_id)->name }}" title="回复"><i class="fas fa-reply"></i></a>
                        @endauth
                        &emsp;{{ $index+1 }}楼
                        </div>

                    </div>
                    <div class="message mt-1">
                        @if($reply->index != 0)
                        <blockquote class="blockquote mb-1">
                            <p class="mb-0 small">{{ App\Reply::find($reply->index)->body }}</p>
                            <footer class="blockquote-footer text-right"><cite class="small"><img src="{{ asset('imgs/user.jpeg') }}" class="user-img-5">{{ App\User::find($reply->from_user_id)->name }}</cite></footer>
                        </blockquote>
                        @endif
                        {{ $reply->body }}
                    </div>
                </div>
            </li>
            @endforeach

            @auth
            @can('thread-reply', $thread)
            <hr>
            <li class="media new-reply">
                <a href="" class="mr-3"><img class="user-img-4" src="{{ asset('imgs/user.jpeg') }}"></a>
                <div class="media-body">
                    <div class="d-flex justify-content-between small text-muted">
                        <div>
                            <span class="font-weight-bold">
                                {{ Auth::user()->name }}
                            </span>
                        </div>
                        <div class="text-right text-grey">
                            <span>{{ count($replies)+1 }}楼</span>
                        </div>
                    </div>
                    <div class="message mt-1 break-all">
                    <form id="reply-form" action="{{ route('reply.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="index" value="0">
                        <input type="hidden" name="thread_id" value="{{ $thread->id }}">
                        <input type="hidden" name="from_user_id" value="{{ Auth::user()->id }}">
                        <input type="hidden" name="to_user_id" value="{{ $thread->user_id }}">
                        <textarea name="body" rows="1" class="form-control mb-2" placeholder="回复楼主"></textarea>
                        <div class="d-flex justify-content-between">
                            <span><i class="fas fa-edit"></i>高级回复</span>
                            <span><button type="submit" class="btn btn-sm btn-primary">回复</button></span>
                        </div>
                    </form>
                    </div>
                </div>
            </li>
            @endcan
            @endauth
        </ul>
    </div>
</div>
@endsection

@section('aside')
@include('inc.card-user')
@endsection

@section('script')
<script>
$(function(){
    const replyForm = $('#reply-form')
    const replyButtons = $('.reply-button')

    const replyIndex = replyForm.find('input[name="index"]')
    const replyToUserId = replyForm.find('input[name="to_user_id"]')
    const replyToUserIdOrigin = replyToUserId.val()
    const replyTextarea = replyForm.find('textarea[name="body"]')

    let reply = 0
    // 评论按钮点击事件
    replyButtons.each(function(){
        $(this).on('click', function(){
            if(reply !== $(this).data('index')){
                replyIndex.val($(this).data('index'))
                replyToUserId.val($(this).data('to_user_id'))
                replyTextarea.attr('placeholder', '回复' + $(this).data('user_name'))
                reply = $(this).data('index')
            }else{
                replyIndex.val(0)
                replyToUserId.val(replyToUserIdOrigin)
                replyTextarea.attr('placeholder', '回复楼主')
                reply = 0
            }
            replyTextarea.focus()
        })
    })

    let timer
    // 回复框聚焦失焦事件
    replyTextarea.on('focus', function(){
        // 清除定时器
        clearTimeout(timer)
        $(this).animate({
            rows: 5
        }, 100)
    }).on('blur', function(){
        timer = setTimeout(function(){
            replyTextarea.animate({
                rows: 1
            }, 100)
        }, 1000)
    })
})
</script>
@endsection