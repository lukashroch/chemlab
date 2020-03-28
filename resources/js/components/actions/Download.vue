<template>
  <a
    class="btn btn-sm btn-primary"
    :title="$t('common.download')"
    target="_blank"
    :href="`${url.api}/${module}/${item.id}`"
  >
    <span class="fas fa-fw fa-file" :title="$t('common.download')"></span>
  </a>
</template>

<script>
import { mapGetters } from 'vuex';
import ActionMixin from './ActionMixin';

export default {
  name: 'Download',

  mixins: [ActionMixin],

  computed: mapGetters(['url']),
};
</script>

<style lang="scss" scoped></style>
