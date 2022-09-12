<template>
  <button class="btn btn-sm btn-danger" :title="$t('common.delete')" type="button" @click="onClick">
    <span class="fas fa-fw fa-trash-alt" :title="$t('common.delete')"></span>
  </button>
</template>

<script lang="ts">
import { defineComponent } from 'vue';

import ActionMixin from './ActionMixin';

export default defineComponent({
  name: 'Delete',

  mixins: [ActionMixin],
});
</script>

<style lang="scss" scoped></style>
