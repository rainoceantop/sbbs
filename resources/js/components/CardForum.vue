<template>
<div class="card">
    <div class="m-3">
        <div class="forum-logo">
            <img v-bind:src="forum_logo" />
            <h5 class="text-center">{{ forum_name }}</h5>
        </div>
        <div class="small line-height-3">
            {{ info }}
        </div>
    </div>
    <div class="card-footer p-2">
        <table class="w-100 small">
            <tbody>
                <tr align="center">
                    <td>
                        <span class="text-muted">帖子总数</span><br>
                        <b>{{ forum_thread_count }}</b>
                    </td>
                    <td>
                        <span class="text-muted">今日帖子</span><br>
                        <b>{{ today_thread_count }}</b>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
</template>

<script>
export default {
  data() {
    return {
      forum_logo: "imgs/forum.jpg",
      forum_name: "公告",
      info:
        "在本组发布测试结果，每个bug一个帖子，标题格式： 项目代号-测试人-简单描述",
      forum_thread_count: 5012,
      today_thread_count: 153
    };
  }
};
</script>

<style scoped>
.forum-logo,
img {
  width: 100%;
}
</style>
