<template>
  <button
    class="btn btn-primary"
    :title="$t('common.action.edit')"
    :disabled="disabled"
    @click.stop="onClick"
  >
    <span class="fas fa-fw fa-pencil-alt" :title="$t('common.action.edit')"></span>
    {{ $t('common.action.edit') }}
  </button>
</template>

<script>
import ActionMixin from './ActionMixin';

export default {
  name: 'Edit',

  mixins: [ActionMixin]
};
</script>

<style scoped></style>
