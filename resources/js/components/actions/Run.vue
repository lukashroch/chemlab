<template>
  <button type="button" class="btn btn-sm btn-primary" :title="$t('common.run')" @click="onClick">
    <span class="fas fa-fw fa-hdd" :title="$t('common.run')"></span>
  </button>
</template>

<script>
import ActionMixin from './ActionMixin';

export default {
  name: 'Run',

  mixins: [ActionMixin],
};
</script>

<style lang="scss" scoped></style>
