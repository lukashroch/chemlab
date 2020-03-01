<template>
  <button
    type="button"
    class="btn btn-sm btn-danger"
    :title="$t('common.action.run')"
    @click.stop="onClick"
  >
    <span class="fas fa-fw fa-hdd" :title="$t('common.action.run')"></span>
  </button>
</template>

<script>
import ActionMixin from './ActionMixin';

export default {
  name: 'Run',

  mixins: [ActionMixin]
};
</script>

<style lang="scss" scoped></style>
