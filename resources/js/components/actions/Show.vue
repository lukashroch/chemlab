<template>
  <router-link
    tag="button"
    class="btn btn-sm btn-primary"
    :title="$t('common.detail')"
    :to="{ name: `${$route.name}.show`, params: { id: item.id } }"
  >
    <span class="fas fa-fw fa-file" :title="$t('common.detail')"></span>
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
