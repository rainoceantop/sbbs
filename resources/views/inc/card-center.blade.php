<section class="col-lg-2 hidden-md hidden-sm left">
    <div class="card">
        <div class="card-body text-center">
            <img src="{{ asset('imgs/user.jpeg') }}" class="user-img-2">
            <br>
            {{ $user->name }}
        </div>
        <div class="list-group list-group-flush text-center">
            <a href="{{ route('user.center', $user->id) }}" class="list-group-item list-group-item-action active" data-active="menu-my">个人资料</a>
            <a href="{{ route('user.threads', $user->id) }}" class="list-group-item list-group-item-action">论坛帖子</a>
            @if($user->id == Auth::user()->id)
                @if(Auth::user()->is_super_admin)
                <a href="{{ route('forum.index') }}" class="list-group-item list-group-item-action">板块管理</a>
                <a href="{{ route('userGroup.index') }}" class="list-group-item list-group-item-action">用户组管理</a>
                <a href="{{ route('tag.index') }}" class="list-group-item list-group-item-action">标签管理</a>
                @endif
                @can('user-view', $user)
                <a href="{{ route('user.index') }}" class="list-group-item list-group-item-action">用户管理</a>
                @endcan
                @can('user-register')
                <a href="{{ route('user.register') }}" class="list-group-item list-group-item-action">注册用户</a>
                @endcan
            @endif
        </div>
    </div>
</section>