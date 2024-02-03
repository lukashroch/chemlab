<template>
  <button
    class="btn btn-primary me-1"
    :disabled="disabled"
    :title="$t('common.print')"
    type="button"
    @click="onClick"
  >
    <span class="fas fa-print" :title="$t('common.print')"></span>
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
