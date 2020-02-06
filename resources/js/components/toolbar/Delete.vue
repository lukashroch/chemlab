<template>
  <button
    type="button"
    class="btn btn-danger"
    :title="$t('common.action.delete')"
    :disabled="disabled"
    @click.stop="onClick"
  >
    <span class="fas fa-fw fa-trash-alt" :title="$t('common.action.delete')"></span>
    {{ $t('common.action.delete') }}
  </button>
</template>

<script>
import ActionMixin from './ActionMixin';

export default {
  name: 'Delete',

  mixins: [ActionMixin]
};
</script>

<style scoped></style>
