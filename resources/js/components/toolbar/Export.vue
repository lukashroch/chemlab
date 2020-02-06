<template>
  <button
    class="btn btn-primary"
    :title="$t('common.action.export')"
    :disabled="disabled"
    @click="$modal.show('toolbar-export')"
  >
    <span class="fas fa-fw fa-file-export" :title="$t('common.action.export')"></span>
    {{ $t('common.action.export') }}
  </button>
</template>

<script>
import ActionMixin from './ActionMixin';

export default {
  name: 'Export',

  mixins: [ActionMixin]
};
</script>

<style scoped></style>
