<section class="col-lg-2 hidden-md hidden-sm left">
    <div class="card">
        <div class="card-body text-center">
            <img src="{{ asset('imgs/user.jpeg') }}" class="user-img-2">
            <br>
            austin
        </div>
        <div class="list-group list-group-flush text-center">
            <a href="{{ route('user.center', Auth::user()->id) }}" class="list-group-item list-group-item-action active" data-active="menu-my">个人资料</a>
            <a href="{{ route('user.threads', Auth::user()->id) }}" class="list-group-item list-group-item-action">论坛帖子</a>
            <a href="{{ route('forum.index') }}" class="list-group-item list-group-item-action">板块管理</a>
            <a href="{{ route('userGroup.index') }}" class="list-group-item list-group-item-action">用户组管理</a>
        </div>
    </div>
</section>