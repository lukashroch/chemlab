<template>
  <toolbar
    v-bind="{
      api,
      filter,
      selected: tracked,
      sort: `${params.sort_column}|${params.sort_direction}`,
    }"
    @refresh="refresh"
  ></toolbar>
  <div class="card">
    <data-table-filter
      :count="totalRows"
      @filter-reset="resetFilter"
      @filter-set="setFilter"
    ></data-table-filter>
    <vue3-datatable
      ref="datatable"
      v-bind="{
        columns,
        rows,
        hasCheckbox: true,
        isServerMode: true,
        loading: isAppLoading,
        sortable: true,
        totalRows,
        pageSize: params.pagesize,
        sortColumn: params.sort_column,
        sortDirection: params.sort_direction,
      }"
      @change="tableChange"
      @row-select="rowSelected"
    >
      <template v-for="(_, scopedSlotName) in $slots" #[scopedSlotName]="slotData">
        <slot :name="scopedSlotName" v-bind="slotData" />
      </template>
      <template #action="{ value }">
        <action-bar v-bind="{ api, item: value }" @refresh="refresh"></action-bar>
      </template>
    </vue3-datatable>
  </div>
</template>
<script lang="ts">
import '@bhplugin/vue3-datatable/dist/style.css';

import type { PropType } from 'vue';
import Vue3Datatable from '@bhplugin/vue3-datatable';
import { mapActions } from 'pinia';
import { computed, defineComponent, reactive, ref } from 'vue';

import type { Dictionary, Pagination } from '@/types';
import ActionBar from '@/components/actions/ActionBar.vue';
import { useHttp } from '@/services';
import { useResource } from '@/stores';

import Toolbar from '../toolbar/Toolbar.vue';
import DataTableFilter from './DataTableFilter.vue';

export type SortItem = {
  column: string;
  direction: 'asc' | 'desc';
};

export type DataTableChange = {
  change_type: 'page' | 'sort' | 'column_filters' | 'pagesize' | 'search';
  column_filters: { column: string; value: string }[];
  current_page: number;
  offset: number;
  pagesize: number;
  search: string;
  sort_column: string;
  sort_direction: 'asc' | 'desc';
};

export default defineComponent({
  name: 'DataTable',

  components: { ActionBar, DataTableFilter, Toolbar, Vue3Datatable },

  props: {
    apiUrl: {
      type: String,
    },
    columns: {
      type: Array as PropType<Dictionary[]>,
      required: true,
    },
    defaultSort: {
      type: Object as PropType<SortItem>,
      default: () => ({ column: 'name', direction: 'asc' }),
    },
    trackBy: {
      type: String,
      default: 'id',
    },
  },

  setup(props) {
    const http = useHttp();
    const resource = useResource();

    const datatable: any = ref(null);
    const rows = ref<Dictionary[]>([]);
    const selected = ref<Dictionary[]>([]);
    const totalRows = ref(0);
    let params = reactive<DataTableChange>({
      change_type: 'page',
      column_filters: [],
      current_page: 1,
      offset: 0,
      pagesize: 50,
      search: '',
      sort_column: props.defaultSort?.column ?? 'name',
      sort_direction: props.defaultSort?.direction ?? 'asc',
    });

    const api = computed(() => props.apiUrl ?? resource.name);
    const filter = computed(() => resource.getFilter);
    const tracked = computed(() =>
      selected.value.map((item) => item[props.trackBy]).filter(Boolean)
    );

    const fetch = async () => {
      const { current_page, pagesize, sort_column, sort_direction } = params;
      const sort = `${sort_column}|${sort_direction}`;

      const {
        data: { data, meta },
      } = await http.get<Pagination>(api.value, {
        params: { per_page: pagesize, page: current_page, sort, ...filter.value },
        withLoading: true,
      });

      rows.value = data;
      params.current_page = meta.current_page;
      params.pagesize = meta.per_page;
      totalRows.value = meta.total;
    };

    const tableChange = async (event: DataTableChange) => {
      params = { ...event };
      await fetch();
    };

    const clearSelectedRows = () => {
      datatable.value.clearSelectedRows();
      selected.value = datatable.value.getSelectedRows();
    };

    const rowSelected = () => {
      selected.value = datatable.value.getSelectedRows();
    };

    return {
      api,
      datatable,
      fetch,
      filter,
      rows,
      selected,
      tableChange,
      totalRows,
      params,
      clearSelectedRows,
      rowSelected,
      tracked,
    };
  },

  watch: {
    async $route() {
      await this.request();
      await this.fetch();
    },
  },

  async mounted() {
    await this.request();
    await this.fetch();
  },

  methods: {
    ...mapActions(useResource, {
      request: 'request',
      setResourceFilter: 'setFilter',
      resetResourceFilter: 'resetFilter',
    }),

    async setFilter(data: Dictionary) {
      await this.setResourceFilter(data);
      await this.fetch();
    },

    async resetFilter() {
      this.clearSelectedRows();
      await this.resetResourceFilter();
      await this.fetch();
    },

    async refresh() {
      await this.fetch();
    },
  },
});
</script>

<style lang="scss">
.bh-pagination {
  padding-left: 1rem;
  padding-right: 1rem;
}
</style>
