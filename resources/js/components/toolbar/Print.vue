<template>
  <button
    class="btn btn-primary"
    :disabled="disabled"
    :title="$t('common.print').toString()"
    type="button"
    @click="onClick"
  >
    <span class="fas fa-fw fa-print" :title="$t('common.print').toString()"></span>
    {{ $t('common.print') }}
  </button>
</template>

<script lang="ts">
import { defineComponent } from 'vue';

import ActionMixin from './ActionMixin';

export default defineComponent({
  name: 'Print',

  mixins: [ActionMixin],
});
</script>

<style lang="scss" scoped></style>
