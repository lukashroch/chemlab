<template>
  <button
    class="btn btn-danger"
    :disabled="disabled"
    :title="$t('common.delete')"
    type="button"
    @click="onClick"
  >
    <span class="fas fa-fw fa-trash-alt" :title="$t('common.delete')"></span>
    {{ $t('common.delete') }}
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
