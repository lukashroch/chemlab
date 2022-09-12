<template>
  <resource-table></resource-table>
</template>

<script lang="ts">
import { defineComponent } from 'vue';

import ResourceTable from '@/components/tables/ResourceTable.vue';

export default defineComponent({
  name: 'List',

  components: { ResourceTable },
});
</script>
