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

<script lang="ts">
import { defineComponent } from 'vue';

export default defineComponent({
  name: 'Error',

  props: {
    msg: {
      type: Array,
      default() {
        return [];
      },
    },
  },
});
</script>

<style lang="scss" scoped></style>
