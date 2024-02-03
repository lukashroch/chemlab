<template>
  <button class="btn btn-sm btn-primary" :title="$t('common.run')" type="button" @click="onClick">
    <span class="fas fa-hdd" :title="$t('common.run')"></span>
  </button>
</template>

<script lang="ts">
import { defineComponent } from 'vue';

import ActionMixin from './ActionMixin';

export default defineComponent({
  name: 'Run',

  mixins: [ActionMixin],
});
</script>

<style lang="scss" scoped></style>
