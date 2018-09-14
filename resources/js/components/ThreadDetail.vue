<template>
<div>
    <h3>hello</h3>
    <h5></h5>
</div>
</template>

<script>
export default {
  data() {
    return {
      title: "",
      body: ""
    };
  },
  created() {},
  methods: {
    getThreadDetail(id) {
      axios.get("api/thread/" + id).then(response => {
        console.log(response.data);
      });
    }
  }
};
</script>