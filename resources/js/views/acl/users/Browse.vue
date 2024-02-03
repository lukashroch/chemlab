<template>
  <data-table v-bind="{ columns }">
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
  name: 'UserList',

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
        field: 'email',
        title: t('common.email'),
        sortField: 'email',
      },
      /*{
        name: 'roles',
        title: 'roles.index',
        formatter: value => (value ? value.join(', ') : '')
      },*/
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
