<template>
  <a
    class="btn btn-sm btn-primary"
    :href="`${url.api}/${module}/${item.id}`"
    target="_blank"
    :title="$t('common.download')"
  >
    <span class="fas fa-fw fa-file" :title="$t('common.download')"></span>
  </a>
</template>

<script lang="ts">
import { defineComponent } from 'vue';
import { mapGetters } from 'vuex';

import ActionMixin from './ActionMixin';

export default defineComponent({
  name: 'Download',

  mixins: [ActionMixin],

  computed: mapGetters(['url']),
});
</script>

<style lang="scss" scoped></style>
