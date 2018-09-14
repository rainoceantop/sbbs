@extends('layouts.app')

@section('link')
@endsection

@section('main')
<div class="card card-thread">
    <div class="card-body">
        <section class="thread-title">
            <img src="{{ asset('imgs/user.jpeg') }}">
            <div class="thread-intro">
                <h4 class="break-all">{{ $thread->title }}</h4>
                <div class="d-flex justify-content-between small">
                    <span class="username">
                        <a href="user-33.htm" class="text-muted font-weight-bold">{{ Auth::user()->name }}</a>
                    </span>
                    <span class="date text-grey ml-2">{{ $thread->created_at->diffForHumans() }}</span>
                    <span class="text-grey ml-2"><i class="icon-eye"></i> 30</span>
                </div>
            </div>
        </section>
        <hr>
        <section class="thread-body">
            <p>{!! $thread->body !!}</p>
        </section>
    </div>
</div>
@endsection

@section('aside')
<div class="card">
    <div class="m-3">
        <div class="user-logo text-center">
            <img class="user-img" src="{{asset('imgs/user.jpeg')}}" />
            <h5 class="text-center">{{ Auth::user()->name }}</h5>
        </div>
    </div>
    <div class="card-footer p-2">
        <table class="w-100 small">
            <tbody>
                <tr align="center">
                    <td>
                        <span class="text-muted">帖子总数</span><br>
                        <b>53435</b>
                    </td>
                    <td>
                        <span class="text-muted">今日帖子</span><br>
                        <b>121</b>
                    </td>
                    <td>
                        <span class="text-muted">注册排名</span><br>
                        <b>4524</b>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection

@section('script')
@endsection