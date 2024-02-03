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
import type { PropType } from 'vue';
import { computed, defineComponent } from 'vue';

export default defineComponent({
  name: 'Error',

  props: {
    msg: {
      type: [Array, String] as PropType<string | string[]>,
      default: () => [],
    },
  },

  setup(props) {
    const errors = computed(() => (Array.isArray(props.msg) ? props.msg : [props.msg]));

    return { errors };
  },
});
</script>

<style lang="scss" scoped></style>
