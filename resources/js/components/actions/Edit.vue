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

<script>
import ActionMixin from './ActionMixin';

export default {
  name: 'Edit',

  mixins: [ActionMixin],
};
</script>

<style lang="scss" scoped></style>
