<template>
  <button type="button" class="btn btn-sm btn-danger" :title="$t('common.delete')" @click="onClick">
    <span class="fas fa-fw fa-trash-alt" :title="$t('common.delete')"></span>
  </button>
</template>

<script>
import ActionMixin from './ActionMixin';

export default {
  name: 'Delete',

  mixins: [ActionMixin],
};
</script>

<style lang="scss" scoped></style>
