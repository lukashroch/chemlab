<template>
  <button
    class="btn btn-primary"
    :title="$t('common.action.detail')"
    :disabled="disabled"
    @click.stop="onClick"
  >
    <span class="fas fa-fw fa-file" :title="$t('common.action.detail')"></span>
    {{ $t('common.action.detail') }}
  </button>
</template>

<script>
import ActionMixin from './ActionMixin';

export default {
  name: 'Show',

  mixins: [ActionMixin]
};
</script>

<style lang="scss" scoped></style>
