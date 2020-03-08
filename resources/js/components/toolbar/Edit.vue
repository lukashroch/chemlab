<template>
  <button
    class="btn btn-primary"
    :title="$t('common.edit')"
    :disabled="disabled"
    @click.stop="onClick"
  >
    <span class="fas fa-fw fa-pencil-alt" :title="$t('common.edit')"></span>
    {{ $t('common.edit') }}
  </button>
</template>

<script>
import ActionMixin from './ActionMixin';

export default {
  name: 'Edit',

  mixins: [ActionMixin]
};
</script>

<style lang="scss" scoped></style>
