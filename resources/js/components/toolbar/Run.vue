<template>
  <button
    class="btn btn-primary"
    :title="$t(`${module}.new`).toString()"
    type="button"
    @click="onClick"
  >
    <span class="fas fa-fw fa-play" :title="$t(`${module}.new`).toString()"></span>
    {{ $t(`${module}.new`) }}
  </button>
</template>

<script lang="ts">
import { defineComponent } from 'vue';

import ActionMixin from './ActionMixin';

export default defineComponent({
  name: 'Run',

  mixins: [ActionMixin],
});
</script>

<style lang="scss" scoped></style>
