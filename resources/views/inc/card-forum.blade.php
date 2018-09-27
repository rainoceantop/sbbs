<div class="card">
    <div class="m-3">
        <div class="forum-logo">
            <img class="w-100 img-responsive" src="{{ asset('imgs/forum.jpg') }}" />
            <h5 class="text-center">{{ $forum->name }}</h5>
        </div>
        <div class="line-height-3">
        {{ $forum->description }}
        </div>
    </div>
    <div class="card-footer p-2">
        <table class="w-100 small">
            <tbody>
                <tr align="center">
                    <td>
                        <span class="text-muted">帖子总数</span><br>
                        <b>{{ $forum_threads_count }}</b>
                    </td>
                    <td>
                        <span class="text-muted">今日帖子</span><br>
                        <b>{{ $forum_today_threads }}</b>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<div class="card mt-3">
    <div class="card-body">
        <h6 class="card-title">
            版主：
        </h6>
        <div class="row">
            @foreach($forum->administrators as $user)
            <div class="col-4 text-center">
                <a href="{{ route('user.center', [$user->id]) }}" title="{{ $user->name }}"><img class="w-100 img-responsive rounded" src="{{ $user->avatar }}"></a>
            </div>
            @endforeach
        </div>
    </div>
</div>