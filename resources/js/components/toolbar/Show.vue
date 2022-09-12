<template>
  <button
    class="btn btn-primary"
    :disabled="disabled"
    :title="$t('common.detail')"
    @click.stop="onClick"
  >
    <span class="fas fa-fw fa-file" :title="$t('common.detail')"></span>
    {{ $t('common.detail') }}
  </button>
</template>

<script>
import ActionMixin from './ActionMixin';

export default {
  name: 'Show',

  mixins: [ActionMixin],
};
</script>

<style lang="scss" scoped></style>
