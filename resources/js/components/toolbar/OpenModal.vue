<template>
  <button class="btn btn-primary" :disabled="disabled" :title="label" @click="$modal.show(name)">
    <span class="fa-fw" :class="icon" :title="label"></span>
    {{ label }}
  </button>
</template>

<script lang="ts">
import { defineComponent } from 'vue';

import ActionMixin from './ActionMixin';

export default defineComponent({
  name: 'OpenModal',

  mixins: [ActionMixin],

  props: {
    name: {
      type: String,
      required: true,
    },
    label: {
      type: String,
      required: true,
    },
    icon: {
      type: String,
      required: true,
    },
  },
});
</script>

<style lang="scss" scoped></style>
