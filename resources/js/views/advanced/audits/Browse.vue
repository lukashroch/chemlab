<template>
  <data-table v-bind="{ columns, defaultSort: { column: 'created_at', direction: 'desc' } }">
    <template #created_at="{ value }">
      {{ formatDate(value.created_at) }}
    </template>
  </data-table>
</template>

<script lang="ts">
import { defineComponent } from 'vue';
import { useI18n } from 'vue-i18n';

import { DataTable } from '@/components/tables';
import { useDateTime } from '@/composables';

export default defineComponent({
  name: 'AuditList',

  components: { DataTable },

  setup() {
    const { t } = useI18n();
    const { formatDate } = useDateTime();

    const columns = [
      {
        field: 'name',
        title: t('common.name'),
        sortField: 'name',
      },
      {
        field: 'auditable_type',
        title: t('audits.type'),
        sortField: 'auditable_type',
      },
      {
        field: 'auditable_name',
        title: t('audits.name'),
        sortField: 'auditable_name',
      },
      {
        field: 'event',
        title: t('audits.event'),
        sortField: 'event',
      },
      {
        field: 'created_at',
        title: t('common.created_at'),
        sortField: 'created_at',
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
