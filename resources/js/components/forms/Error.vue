<template>
  <div>
    <small
      v-for="(error, idx) in errors"
      :key="idx"
      class="form-text text-danger mb-0"
      v-text="error"
    ></small>
  </div>
</template>

<script lang="ts">
import { defineComponent } from 'vue';

export default defineComponent({
  name: 'Error',

  props: {
    msg: {
      type: [String, Array],
      default: () => [],
    },
  },

  computed: {
    errors(): string[] {
      return Array.isArray(this.msg) ? this.msg : [this.msg];
    },
  },
});
</script>

<style lang="scss" scoped></style>
