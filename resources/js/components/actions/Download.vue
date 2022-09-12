<template>
  <a
    class="btn btn-sm btn-primary"
    :href="`${url.api}/${module}/${item.id}`"
    target="_blank"
    :title="$t('common.download').toString()"
  >
    <span class="fas fa-fw fa-file" :title="$t('common.download').toString()"></span>
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
