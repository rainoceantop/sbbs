<template>
<div class="card">
    <div class="m-3">
        <h5 class="text-center">
            深圳市软信通网络科技有限公司
        </h5>
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
                        <b>{{ all_thread_count }}</b>
                    </td>
                    <td>
                        <span class="text-muted">今日帖子</span><br>
                        <b>{{ today_thread_count }}</b>
                    </td>
                    <td>
                        <span class="text-muted">用户数</span><br>
                        <b>{{ member_count }}</b>
                    </td>
                    <td>
                        <span class="text-muted">在线</span><br>
                        <b>{{ online_count }}</b>
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
      info: "深圳市软信通网络科技有限公司内部办公网站，非本公司人员禁止访问",
      all_thread_count: 5131512,
      today_thread_count: 1315,
      member_count: 12152,
      online_count: 151
    };
  }
};
</script>