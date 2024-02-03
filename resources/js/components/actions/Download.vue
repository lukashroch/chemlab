<template>
  <a
    class="btn btn-sm btn-primary"
    :href="`${url.api}/${route}/${item.id}`"
    target="_blank"
    :title="$t('common.download')"
  >
    <span class="fas fa-file" :title="$t('common.download')"></span>
  </a>
</template>

<script lang="ts">
import { mapState } from 'pinia';
import { defineComponent } from 'vue';

import { useApp } from '@/stores';

import ActionMixin from './ActionMixin';

export default defineComponent({
  name: 'Download',

  mixins: [ActionMixin],

  computed: mapState(useApp, ['url']),
});
</script>

<style lang="scss" scoped></style>
