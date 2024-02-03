<template>
  <data-table v-bind="{ columns, defaultSort: { column: 'created_at', direction: 'desc' } }">
    <template #available_at="{ value }">
      {{ formatDate(value.available_at) }}
    </template>
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
  name: 'JobList',

  components: { DataTable },

  setup() {
    const { t } = useI18n();
    const { formatDate } = useDateTime();

    const columns = [
      {
        field: 'id',
        title: t('common.id'),
        sortField: 'id',
      },
      {
        field: 'queue',
        title: t('jobs.queue'),
        sortField: 'queue',
      },
      {
        field: 'title',
        title: t('common.title'),
      },
      {
        field: 'attempts',
        title: t('jobs.attempts'),
        sortField: 'attempts',
      },
      {
        field: 'available_at',
        title: t('common.available_at'),
        sortField: 'available_at',
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
