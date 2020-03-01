<template>
  <router-link
    tag="button"
    class="btn btn-sm btn-primary"
    :title="$t('common.action.detail')"
    :to="{ name: `${$route.name}.show`, params: { id: item.id } }"
  >
    <span class="fas fa-fw fa-file" :title="$t('common.action.detail')"></span>
  </router-link>
</template>

<script>
import ActionMixin from './ActionMixin';

export default {
  name: 'Detail',

  mixins: [ActionMixin]
};
</script>

<style lang="scss" scoped></style>
