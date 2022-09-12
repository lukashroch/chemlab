<template>
  <router-link
    class="btn btn-sm btn-primary"
    tag="button"
    :title="$t('common.detail')"
    :to="{ name: `${$route.name}.show`, params: { id: item.id } }"
  >
    <span class="fas fa-fw fa-file" :title="$t('common.detail')"></span>
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
