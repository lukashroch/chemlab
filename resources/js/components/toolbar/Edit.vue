<template>
  <button
    class="btn btn-primary me-1"
    :disabled="disabled"
    :title="$t('common.edit')"
    @click.stop="onClick"
  >
    <span class="fas fa-pencil-alt" :title="$t('common.edit')"></span>
    {{ $t('common.edit') }}
  </button>
</template>

<script lang="ts">
import { defineComponent } from 'vue';

import ActionMixin from './ActionMixin';

export default defineComponent({
  name: 'Edit',

  mixins: [ActionMixin],
});
</script>

<style lang="scss" scoped></style>
