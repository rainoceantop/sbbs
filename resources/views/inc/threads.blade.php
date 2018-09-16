<div class="card">
    <div class="card-header">
        <ul class="nav nav-pills">
            <li class="nav-item">
                <a class="nav-link active" href="#">最新</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">精华</a>
            </li>
        </ul>
    </div>
    <div class="card-body card-thread-list">
        @foreach($threads as $thread)
        <section class="thread-item thread-title">
            <img src="{{ asset('imgs/user.jpeg') }}">
            <div class="thread-intro">
                <h5 class="break-all"><a href="{{ route('thread.show', [$thread->id]) }}">{{ $thread->title }}</a></h5>
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
