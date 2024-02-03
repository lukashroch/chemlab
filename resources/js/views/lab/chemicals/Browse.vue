<template>
  <data-table v-bind="{ columns }"></data-table>
</template>

<script lang="ts">
import { defineComponent } from 'vue';
import { useI18n } from 'vue-i18n';

import { DataTable } from '@/components/tables';

export default defineComponent({
  name: 'ChemicalList',

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
        field: 'catalog_id',
        title: t('chemicals.brand.id'),
        sortField: 'catalog_id',
      },
      {
        field: 'store',
        title: t('stores.title'),
        sortField: 'store',
      },
      {
        field: 'amount',
        title: t('chemicals.amount'),
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
