<template>
  <resource-table :parts="['toolbar', 'table', 'pagination']"></resource-table>
</template>

<script>
import ResourceTable from '../../components/tables/ResourceTable';

export default {
  name: 'FileList',
  components: { ResourceTable },
};
</script>
