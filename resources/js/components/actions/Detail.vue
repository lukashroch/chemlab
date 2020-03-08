<template>
  <button
    class="btn btn-sm btn-primary"
    :title="$t('common.detail')"
    @click="$modal.show('toolbar-detail', { id: item.id })"
  >
    <span class="fas fa-fw fa-file" :title="$t('common.detail')"></span>
  </button>
</template>

<script>
import ActionMixin from './ActionMixin';

export default {
  name: 'Detail',

  mixins: [ActionMixin]
};
</script>

<style lang="scss" scoped></style>
