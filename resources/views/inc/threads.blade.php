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
            <img src="{{ asset('imgs/user.jpeg') }}" class="user-img-4 mr-3">
            <div class="thread-intro">
                <div class="thread-title-tags">
                    <h5 class="break-all"><a href="{{ route('thread.show', [$thread->id]) }}">{{ $thread->title }}</a></h5>
                    @foreach($thread->tags as $tag)
                    <span class="tag" @php echo "style='background-color:$tag->color'" @endphp><a href="{{ route('forum.show', [$thread->forum_id]) }}?tagids={{ $tag->identity }}">{{ $tag->name }}</a></span>
                    @endforeach
                </div>
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
{{ $threads->links() }}
