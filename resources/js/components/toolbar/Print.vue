<template>
  <button
    type="button"
    class="btn btn-primary"
    :title="$t('common.print')"
    :disabled="disabled"
    @click="onClick"
  >
    <span class="fas fa-fw fa-print" :title="$t('common.print')"></span>
    {{ $t('common.print') }}
  </button>
</template>

<script>
import ActionMixin from './ActionMixin';

export default {
  name: 'Print',

  mixins: [ActionMixin],
};
</script>

<style lang="scss" scoped></style>
