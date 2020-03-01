<template>
  <a
    class="btn btn-sm btn-primary"
    :title="$t('common.action.download')"
    target="_blank"
    :href="`${url.api}/${module}/${item.id}`"
  >
    <span class="fas fa-fw fa-file" :title="$t('common.action.download')"></span>
  </a>
</template>

<script>
import { mapState } from 'vuex';
import ActionMixin from './ActionMixin';

export default {
  name: 'Download',

  mixins: [ActionMixin],

  computed: mapState(['url'])
};
</script>

<style lang="scss" scoped></style>
