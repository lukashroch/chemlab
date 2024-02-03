<template>
  <data-table v-bind="{ columns }"></data-table>
</template>

<script lang="ts">
import { defineComponent } from 'vue';
import { useI18n } from 'vue-i18n';

import { DataTable } from '@/components/tables';

export default defineComponent({
  name: 'JobList',

  components: { DataTable },

  setup() {
    const { t } = useI18n();

    const columns = [
      {
        field: 'name',
        title: t('common.name'),
        sortField: 'name',
      },
      {
        field: 'parse_callback',
        title: t('brands.parse_callback'),
        sortField: 'parse_callback',
      },
      {
        field: 'description',
        title: t('common.description'),
        sortField: 'description',
      },
      {
        field: 'action',
        title: t('common.action'),
        sort: false,
      },
    ];

    return {
      columns,
    };
  },
});
</script>
