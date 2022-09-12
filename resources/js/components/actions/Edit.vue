<template>
  <router-link
    class="btn btn-sm btn-primary"
    tag="button"
    :title="$t('common.edit')"
    :to="{ name: `${module}.edit`, params: { id: item.id } }"
  >
    <span class="fas fa-fw fa-pencil-alt" :title="$t('common.edit')"></span>
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
