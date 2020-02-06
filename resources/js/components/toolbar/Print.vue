<template>
  <button
    type="button"
    class="btn btn-primary"
    :title="$t('common.action.print')"
    :disabled="disabled"
    @click.stop="onClick"
  >
    <span class="fas fa-fw fa-print" :title="$t('common.action.print')"></span>
    {{ $t('common.action.print') }}
  </button>
</template>

<script>
import ActionMixin from './ActionMixin';

export default {
  name: 'Print',

  mixins: [ActionMixin]
};
</script>

<style scoped></style>
