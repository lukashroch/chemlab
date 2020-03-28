<template>
  <a
    class="btn btn-sm btn-primary"
    :href="`${module}/${item.id}/print`"
    :title="$t('common.print')"
  >
    <span class="fas fa-fw fa-print" :title="$t('common.print')"></span>
  </a>
</template>

<script>
import ActionMixin from './ActionMixin';

export default {
  name: 'Print',

  mixins: [ActionMixin],
};
</script>

<style lang="scss" scoped></style>
