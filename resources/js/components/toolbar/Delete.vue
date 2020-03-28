<template>
  <button
    type="button"
    class="btn btn-danger"
    :title="$t('common.delete')"
    :disabled="disabled"
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
