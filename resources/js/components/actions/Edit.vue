<template>
  <router-link
    tag="button"
    class="btn btn-sm btn-primary"
    :title="$t('common.action.edit')"
    :to="{ name: `${module}.edit`, params: { id: item.id } }"
  >
    <span class="fas fa-fw fa-pencil-alt" :title="$t('common.action.edit')"></span>
  </router-link>
</template>

<script>
import ActionMixin from './ActionMixin';

export default {
  name: 'Edit',

  mixins: [ActionMixin]
};
</script>

<style scoped></style>
