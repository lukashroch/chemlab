<template>
  <button class="btn btn-primary" :title="$t(`${module}.new`)" type="button" @click="onClick">
    <span class="fas fa-fw fa-play" :title="$t(`${module}.new`)"></span>
    {{ $t(`${module}.new`) }}
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
