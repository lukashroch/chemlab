<template>
  <button
    class="btn btn-primary"
    :disabled="disabled"
    :title="$t('common.detail')"
    @click.stop="onClick"
  >
    <span class="fas fa-fw fa-file" :title="$t('common.detail')"></span>
    {{ $t('common.detail') }}
  </button>
</template>

<script lang="ts">
import { defineComponent } from 'vue';

import ActionMixin from './ActionMixin';

export default defineComponent({
  name: 'Show',

  mixins: [ActionMixin],
});
</script>

<style lang="scss" scoped></style>
