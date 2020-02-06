<template>
  <router-link
    tag="button"
    class="btn btn-primary"
    :to="{ name: `${module}.create`, params: { id: 'create' } }"
    :title="$t(`${module}.new`)"
  >
    <span class="fas fa-plus" :title="$t(`${module}.new`)"></span>
    {{ $t(`${module}.new`) }}
  </router-link>
</template>

<script>
import ActionMixin from './ActionMixin';

export default {
  name: 'Create',

  mixins: [ActionMixin]
};
</script>

<style scoped></style>
