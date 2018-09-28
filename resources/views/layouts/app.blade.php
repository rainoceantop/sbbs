<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/fontawesome.all.css') }}">
    @section('link')
    @show
    <title>软信通 - @yield('title')</title>
</head>
<body>
@php
$have_forum_id = isset($forum_id);
@endphp
    <div id="app">
        <!-- 导航栏  -->
        <header class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container">
                <a class="navbar-brand" style="font-family: 楷体;font-weight:bold;" href="/">软信通</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item @if($have_forum_id ? $forum_id == 0 : FALSE) active @endif">
                            <a class="nav-link" href="/"> 首页 <span class="sr-only">(current)</span></a>
                        </li>
                        @foreach(App\Forum::all() as $forum)
                        <li class="nav-item @if($have_forum_id ? $forum_id == $forum->id : FALSE) active @endif">
                            <a class="nav-link" href="{{ route('forum.show', [$forum->id]) }}">{{ $forum->name }}</a>
                        </li>
                        @endforeach
                    </ul>
                    <ul class="navbar-nav">
                        @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('登录') }}</a>
                        </li>
                    
                        @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('user.center', Auth::user()->id) }}">个人中心</a>
                                <a class="dropdown-item" href="{{ route('user.threads', Auth::user()->id) }}">论坛帖子</a>
                                <!-- 是否版主或超级管理员 -->
                                @if(Auth::user()->forums()->count() > 0 || Auth::user()->is_super_admin)
                                <div class="dropdown-divider"></div>
                                <a href="{{ route('forum.index') }}" class="dropdown-item">板块管理</a>
                                <a href="{{ route('tag.index') }}" class="dropdown-item">标签管理</a>
                                <div class="dropdown-divider"></div>
                                @endif
                                @if(Auth::user()->is_super_admin)
                                <div class="dropdown-divider"></div>
                                <a href="{{ route('userGroup.index') }}" class="dropdown-item">用户组管理</a>
                                <div class="dropdown-divider"></div>
                                @endif
                                @can('user-view', Auth::user())
                                <div class="dropdown-divider"></div>
                                <a href="{{ route('user.index') }}" class="dropdown-item">用户管理</a>
                                <div class="dropdown-divider"></div>
                                @endcan
                                @can('user-register')
                                <div class="dropdown-divider"></div>
                                <a href="{{ route('user.register') }}" class="dropdown-item">注册用户</a>
                                <div class="dropdown-divider"></div>
                                @endcan
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                                    document.getElementById('logout-form').submit();">
                                    {{ __('退出登录') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </li>
                        @endguest

                    </ul>
                </div>
                
            </div>
        </header>
        <!-- 内容 -->
        <main>
            <div class="container">
                @section('content')
                <div class="row">
                    <section class="col-lg-9 left">
                        @yield('main')
                    </section>
                    <section class="col-lg-3 d-lg-block right">
                        <a role="button" class="btn btn-primary btn-block mb-3" @if($have_forum_id) href="{{ url('thread/create?fid='.$forum_id) }}" @endif>发新帖</a>
                        @yield('aside')
                    </section>
                </div>
                @show
            </div>
        </main>
        <!-- 页脚 -->
        <footer class="text-muted small bg-dark py-4 mt-3">
            <div class="container">
                <div class="row">
                    <div class="col">
                        Powered by
                        <a href="/" class="text-muted">深圳市软信通网络科技有限公司</a>
                    </div>
                    <div class="col text-right">
                        粤ICP备20180913号-1
                    </div>
                </div>
            </div>
        </footer>
    </div>
    <script src="{{ asset('js/app.js') }}"></script>
    @section('script')
    @show
</body>
</html>