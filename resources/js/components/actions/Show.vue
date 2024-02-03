<template>
  <router-link :to="{ name: `${route}.show`, params: { id: item.id } }">
    <button class="btn btn-sm btn-primary" :title="$t('common.detail')">
      <span class="fas fa-file" :title="$t('common.detail')"></span>
    </button>
  </router-link>
</template>

<script lang="ts">
import { defineComponent } from 'vue';

import ActionMixin from './ActionMixin';

export default defineComponent({
  name: 'Detail',

  mixins: [ActionMixin],
});
</script>

<style lang="scss" scoped></style>
