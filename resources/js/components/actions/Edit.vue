<template>
  <router-link :to="{ name: `${route}.edit`, params: { id: item.id } }">
    <button class="btn btn-sm btn-primary" :title="$t('common.edit')">
      <span class="fas fa-pencil-alt" :title="$t('common.edit')"></span>
    </button>
  </router-link>
</template>

<script lang="ts">
import { defineComponent } from 'vue';

import ActionMixin from './ActionMixin';

export default defineComponent({
  name: 'Edit',

  mixins: [ActionMixin],
});
</script>

<style lang="scss" scoped></style>
