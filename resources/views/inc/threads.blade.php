<table class="nav_tag_list mb-2">
    @if(!empty($forum))
    @foreach($forum->tagGroups as $index => $tagGroup)
    <tr>
        <td class="text-muted text-nowrap" align="right" valign="top">
            {{ $tagGroup->name }}：
        </td>
        <td>
            @php
                // 每一组标签拷贝上次选择的标签
                $new_tag_ids = $tag_ids;

                // 全部：更改自己所在位置的标签id为0
                $new_tag_ids[$index] = 0;
                // 组合新的url
                $all_url = implode('_', $new_tag_ids);
            @endphp

            <a href="{{ route('forum.show', [$forum->id]) }}?tagids={{ $all_url }}"  @if($tag_ids[$index] == 0) class="active" @endif>全部</a>

            @foreach($tagGroup->tags as $tag)
            @php
                // 标签：更改自己所在位置的标签id
                $new_tag_ids[$index] = $tag->identity;
                // 组合新的url
                $url = implode('_', $new_tag_ids);
            @endphp
            <a href="{{ route('forum.show', [$forum->id]) }}?tagids={{ $url }}"  @if($tag_ids[$index] == $tag->identity) class="active" @endif>{{ $tag->name }}</a>
            @endforeach
        </td>
    </tr>
    @endforeach
    @endif
</table>
<div class="card mb-3">
    <div class="card-header">
        <ul class="nav nav-pills">
            <li class="nav-item">
                <a class="nav-link @if($category_id == 0) active @endif" href="{{ empty($forum) ? '/' : route('forum.show', [$forum->id]) }}">最新</a>
            </li>
            <li class="nav-item">
                <a class="nav-link @if($category_id == 1) active @endif" href="{{ empty($forum) ? '' : route('forum.show', [$forum->id]) }}?type=good">精华</a>
            </li>
            @if(!empty($forum))
            <li class="nav-item">
            <a class="nav-link @if($category_id == 2) active @endif" href="{{ route('forum.show', [$forum->id]) }}?type=filed">归档</a>
            </li>
            @endif
            <li class="nav-item dropdown justify-content-end">
                <a class="nav-link dropdown-toggle @if($category_id == 3) active @endif" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">发贴人@if($user_id) ：{{ App\User::find($user_id)->name }} @endif</a>
                <div class="dropdown-menu">
                @foreach($forum_users as $forum_user)
                    <a class="dropdown-item"  href="{{ empty($forum) ? '' : route('forum.show', [$forum->id]) }}?type=user&user_id={{ $forum_user->id }}">@if($user_id == $forum_user->id) <i class="far fa-dot-circle text-success"></i>&nbsp; @else &emsp;&nbsp; @endif{{ $forum_user->name }}</a>
                @endforeach
                </div>
            </li>
        </ul>
    </div>
    <div class="card-body card-thread-list">
        @foreach($threads as $thread)
        <section class="thread-item thread-title">
            <a href="{{ route('user.center', $thread->user_id) }}"><img src="{{ asset( $thread->user->avatar ) }}" class="user-img-4 mr-3"></a>
            <div class="thread-intro w-100">
                <div class="thread-title-tags">
                    <!-- 标题 -->
                    <h5 class="break-all">@if($thread->is_top) <span class="text-success"><i class="far fa-flag fa-sm mr-2" title="置顶"></i></span> @endif<a href="{{ route('thread.show', [$thread->id]) }}">{{ $thread->title }}</a>
                    @foreach($thread->tags as $tag)
                    <!-- 标签 -->
                    <span class="tag" @php echo "style='background-color:$tag->color'" @endphp><a href="{{ route('forum.show', [$thread->forum_id]) }}?tagids={{ $tag->identity }}">{{ $tag->name }}</a></span>
                    @endforeach
                    <!-- 图标 -->
                    @if($thread->is_filed)<span class="ml-2 text-secondary"><i class="far fa-file-alt fa-sm" title="已归档"></i></span>@endif
                    @if($thread->is_good)<span class="ml-2 text-info"><i class="far fa-gem fa-sm" title="精华"></i></span>@endif
                    </h5>
                </div>
                <div class="d-flex small justify-content-between text-muted">
                    <!-- 左 -->
                    <div>
                        <span class="username">
                            <a href="{{ route('user.center', $thread->user_id) }}" class="text-muted">{{ $thread->user->name }}</a>
                        </span>
                        <span class="date ml-2">{{ $thread->created_at->diffForHumans() }}</span>
                        @if( $thread->replies()->count() > 0 )
                        &nbsp;<i class="fas fa-arrow-left ml-2"></i>&nbsp;
                        <span class="ml-2">{{ $thread->replies()->orderBy('created_at', 'desc')->first()->user->name }}</span>
                        <span class="ml-2">{{ $thread->replies()->orderBy('created_at', 'desc')->first()->created_at->diffForHumans() }}</span>
                        @endif
                    </div>
                    <!-- 右 -->
                    <div>
                    <i class="far fa-comment"></i>&nbsp;{{ $thread->replies()->count() }}
                    </div>
                </div>
            </div>
        </section>
        @endforeach
    </div>
</div>
{{ $threads->links() }}
