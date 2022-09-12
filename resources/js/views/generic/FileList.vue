<template>
  <resource-table :parts="['toolbar', 'table', 'pagination']"></resource-table>
</template>

<script lang="ts">
import { defineComponent } from 'vue';

import ResourceTable from '@/components/tables/ResourceTable.vue';

export default defineComponent({
  name: 'FileList',

  components: { ResourceTable },
});
</script>
