<div class="card d-none d-lg-block d-md-none d-sm-none">
    <div class="m-3">
        <div class="user-logo text-center">
            <img class="user-img-2 mb-2" src="{{asset($thread->user->avatar)}}" />
            <h5 class="text-center">{{ $thread->user->name }}</h5>
        </div>
    </div>
    <div class="card-footer p-2">
        <table class="w-100 small">
            <tbody>
                <tr align="center">
                    <td>
                        <span class="text-muted">帖子总数</span><br>
                        <b>{{ $user_threads_count }}</b>
                    </td>
                    <td>
                        <span class="text-muted">今日帖子</span><br>
                        <b>{{ $user_today_threads }}</b>
                    </td>
                    <td>
                        <span class="text-muted">注册排名</span><br>
                        <b>{{ $user_id }}</b>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>