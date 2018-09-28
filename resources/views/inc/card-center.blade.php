<section class="col-lg-2 hidden-md hidden-sm left">
    <div class="card">
        <div class="card-body text-center">
            <img src="{{ asset( $user->avatar ) }}" class="user-img-2">
            <br>
            {{ $user->name }}
        </div>
        <div class="list-group list-group-flush text-center">
            <a href="{{ route('user.center', $user->id) }}" class="list-group-item list-group-item-action @if($category_id == 0) active @endif" data-active="menu-my">个人资料</a>
            <a href="{{ route('user.threads', $user->id) }}" class="list-group-item list-group-item-action @if($category_id == 1) active @endif">论坛帖子</a>
            <!-- 判断是否访问本人中心，如果不是不开放 -->
            @if($user->id == Auth::user()->id)
                <!-- 是否版主或超级管理员 -->
                @if(Auth::user()->forums()->count() > 0 || Auth::user()->is_super_admin)
                <a href="{{ route('forum.index') }}" class="list-group-item list-group-item-action @if($category_id == 2) active @endif">板块管理</a>
                <a href="{{ route('tag.index') }}" class="list-group-item list-group-item-action @if($category_id == 3) active @endif">标签管理</a>
                @endif
                @if(Auth::user()->is_super_admin)
                <a href="{{ route('userGroup.index') }}" class="list-group-item list-group-item-action @if($category_id == 4) active @endif">用户组管理</a>
                @endif
                @can('user-view', $user)
                <a href="{{ route('user.index') }}" class="list-group-item list-group-item-action @if($category_id == 5) active @endif">用户管理</a>
                @endcan
                @can('user-register')
                <a href="{{ route('user.register') }}" class="list-group-item list-group-item-action @if($category_id == 6) active @endif">注册用户</a>
                @endcan
            @endif
        </div>
    </div>
</section>