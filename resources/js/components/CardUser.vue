<template>
<div class="card">
    <div class="m-3">
        <div class="user-logo text-center">
            <img v-bind:src="user_logo" />
            <h5 class="text-center">{{ user_name }}</h5>
        </div>
    </div>
    <div class="card-footer p-2">
        <table class="w-100 small">
            <tbody>
                <tr align="center">
                    <td>
                        <span class="text-muted">帖子总数</span><br>
                        <b>{{ user_thread_count }}</b>
                    </td>
                    <td>
                        <span class="text-muted">今日帖子</span><br>
                        <b>{{ today_thread_count }}</b>
                    </td>
                    <td>
                        <span class="text-muted">注册排名</span><br>
                        <b>{{ register_rank }}</b>
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
      user_logo: "/imgs/user.jpeg",
      user_name: "卡西莫多",
      user_thread_count: 201,
      today_thread_count: 3,
      register_rank: 123
    };
  }
};
</script>

<style scoped>
img {
  width: 100px;
  height: 100px;
  border-radius: 50px;
  border: 1px lightgray solid;
  padding: 2px;
  margin-bottom: 1rem;
}
</style>
