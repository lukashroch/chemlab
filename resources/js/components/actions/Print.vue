<template>
  <a
    class="btn btn-sm btn-primary"
    :href="`${module}/${item.id}/print`"
    :title="$t('common.print').toString()"
  >
    <span class="fas fa-fw fa-print" :title="$t('common.print').toString()"></span>
  </a>
</template>

<script lang="ts">
import { defineComponent } from 'vue';

import ActionMixin from './ActionMixin';

export default defineComponent({
  name: 'Print',

  mixins: [ActionMixin],
});
</script>

<style lang="scss" scoped></style>
