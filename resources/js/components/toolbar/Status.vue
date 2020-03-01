<template>
  <button
    class="btn btn-primary"
    :title="$t('common.status.change')"
    :disabled="disabled"
    @click="$modal.show('toolbar-status')"
  >
    <span class="fas fa-fw fa-exchange-alt" :title="$t('common.status.change')"></span>
    {{ $t('common.status.change') }}
  </button>
</template>

<script>
import ActionMixin from './ActionMixin';

export default {
  name: 'Status',

  mixins: [ActionMixin]
};
</script>

<style lang="scss" scoped></style>
