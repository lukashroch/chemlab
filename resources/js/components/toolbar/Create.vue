<template>
  <router-link
    class="btn btn-primary"
    tag="button"
    :title="$t(`${module}.new`)"
    :to="{ name: `${module}.create`, params: { id: 'create' } }"
  >
    <span class="fas fa-plus" :title="$t(`${module}.new`).toString()"></span>
    {{ $t(`${module}.new`) }}
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
