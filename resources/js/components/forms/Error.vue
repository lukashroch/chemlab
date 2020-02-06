<template>
  <div>
    <template v-for="(err, idx) in msg">
      <small :key="idx" class="form-text text-danger mb-0" v-text="err"></small>
    </template>
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
