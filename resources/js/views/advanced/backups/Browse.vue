<template>
  <data-table v-bind="{ columns, defaultSort: { column: 'date', direction: 'desc' } }"></data-table>
</template>

<script lang="ts">
import { defineComponent } from 'vue';
import { useI18n } from 'vue-i18n';

import { DataTable } from '@/components/tables';
import { useDateTime } from '@/composables';

export default defineComponent({
  name: 'BackupList',

  components: { DataTable },

  setup() {
    const { t } = useI18n();
    const { formatDate } = useDateTime();

    const columns = [
      {
        name: 'name',
        title: t('common.name'),
        sortField: 'name',
        cellRenderer: (value: any) => `<span class="fas fa-file-code"></span> ${value.name}`,
      },
      {
        name: 'date',
        title: t('common.date'),
        sortField: 'date',
        cellRenderer: (value: any) => formatDate(value.date * 1000),
      },
      {
        name: 'size',
        title: t('common.size'),
        sortField: 'size',
        cellRenderer: (value: any) => `${Math.floor((value.size / 1024) * 100) / 100} KB`,
      },
      {
        field: 'action',
        title: t('common.action'),
        sort: false,
      },
    ];

    return {
      columns,
      formatDate,
    };
  },
});
</script>
