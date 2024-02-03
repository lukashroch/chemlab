<template>
  <router-link :to="{ name: `${module}.create` }">
    <button class="btn btn-primary me-1" :title="$t(`${module}.new`)">
      <span class="fas fa-plus" :title="$t(`${module}.new`)"></span>
      {{ $t(`${module}.new`) }}
    </button>
  </router-link>
</template>

<script lang="ts">
import { defineComponent } from 'vue';

import ActionMixin from './ActionMixin';

export default defineComponent({
  name: 'Create',

  mixins: [ActionMixin],
});
</script>

<style lang="scss" scoped></style>
