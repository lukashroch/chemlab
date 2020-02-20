<template>
  <div>
    <small
      v-for="(err, idx) in msg"
      :key="idx"
      class="form-text text-danger mb-0"
      v-text="err"
    ></small>
  </div>
</template>

<script>
export default {
  name: 'Error',

  props: {
    msg: {
      type: Array,
      default() {
        return [];
      }
    }
  }
};
</script>

<style scoped></style>
