<script lang="ts">
import type { PropType } from 'vue';
import { mapActions, mapState } from 'pinia';
import Vue, { defineComponent } from 'vue';

import Toolbar from '@/components/toolbar/Toolbar.vue';
import { handlesLoading } from '@/mixins';
import { useResource, useUser } from '@/stores';

import TableFilter from './TableFilter.vue';
import VuetableStyle from './VuetableStyling';

export default defineComponent({
  name: 'AdminTable',

  components: { TableFilter, Toolbar },

  mixins: [handlesLoading],

  props: {
    fields: {
      type: Array,
      required: true,
    },
    sortOrder: {
      type: Array,
      default() {
        return [];
      },
    },
    parts: {
      type: Array as PropType<string[]>,
      default() {
        return ['toolbar', 'filter', 'table', 'pagination'];
      },
    },
    httpMethod: {
      type: String,
      default: 'get',
    },
    detailRowComponent: {
      type: String,
      default: '',
    },
  },

  data() {
    return {
      css: VuetableStyle,
      count: 0,
      selected: [],
      selectedItems: [],
    };
  },

  computed: {
    ...mapState(useUser, ['profile']),
    ...mapState(useResource, { activeFilter: 'getFilter' }),
    tableParts(): string[] {
      return this.parts.filter((item) => item !== 'toolbar');
    },
    trackBy(): string {
      return this.module === 'chemicals' ? 'item_id' : 'id';
    },
  },

  methods: {
    ...mapActions(useResource, {
      setResourceFilter: 'setFilter',
      resetResourceFilter: 'resetFilter',
    }),

    getRenderParts(h) {
      return this.tableParts.map((item) => this[item](h));
    },

    toolbar(h) {
      return h('toolbar', {
        class: { card: true, 'card-border': true, 'mb-4': true },
        props: {
          // TODO: check if using filter
          appendParams: this.activeFilter,
          sortOrder: this.sortOrder,
          selected: this.selected,
          selectedItems: this.selectedItems,
          trackBy: this.trackBy,
        },
        on: {
          'toolbar-update': this.onToolbarUpdate,
        },
        scopedSlots: this.$vnode.data.scopedSlots,
      });
    },

    filter(h) {
      return h('table-filter', {
        props: {
          count: this.count,
        },
        on: {
          'vt-filter-set': this.onFilterSet,
          'vt-filter-reset': this.onFilterReset,
        },
      });
    },

    table(h) {
      return h('vuetable', {
        name: 'vuetable',
        ref: 'vuetable',
        props: {
          apiUrl: this.module,
          fields: this.fields,
          dataPath: 'data',
          paginationPath: 'pagination',
          perPage: this.profile?.settings.listing ?? 50,
          transform: this.transform,
          sortOrder: this.sortOrder,
          appendParams: this.activeFilter,
          css: this.css.table,
          httpMethod: this.httpMethod,
          httpFetch: this.$http.axios[this.httpMethod],
          detailRowComponent: this.detailRowComponent,
          trackBy: this.trackBy,
        },
        on: {
          'vuetable:loading': this.onLoading,
          'vuetable:loaded': this.onLoaded,
          'vuetable:pagination-data': this.onPaginationData,
          'vuetable:checkbox-toggled': this.onCheckboxToggled,
          'vuetable:checkbox-toggled-all': this.onCheckboxToggled,
          'vuetable:cell-clicked': this.onCellClicked,
        },
        scopedSlots: this.$vnode.data.scopedSlots,
      });
    },

    pagination(h) {
      return h('div', { class: { 'card-body': true } }, [
        h('div', { class: { row: true, 'justify-content-between': true } }, [
          h('vuetable-pagination-info', {
            class: { 'col-auto': true },
            ref: 'paginationInfo',
          }),
          h('vuetable-pagination', {
            class: { 'col-auto': true },
            ref: 'pagination',
            props: {
              css: this.css.pagination,
            },
            on: {
              'vuetable-pagination:change-page': this.onChangePage,
            },
          }),
        ]),
      ]);
    },

    transform(res) {
      const { data, meta, links } = res;
      return {
        data,
        pagination: {
          ...meta,
          ...{
            last_page_url: links.last,
            next_page_url: links.next,
            prev_page_url: links.prev,
          },
        },
      };
    },

    onLoading() {
      this.addLoading('list');
    },

    onLoaded() {
      this.removeLoading('list');
    },

    onPaginationData(data) {
      this.$refs.pagination.setPaginationData(data);
      this.$refs.paginationInfo.setPaginationData(data);
      this.count = data.total;
    },

    onCheckboxToggled() {
      this.updateSelected();
    },

    onCellClicked(cellData) {
      if (this.$refs.vuetable.useDetailRow === true) {
        this.$refs.vuetable.toggleDetailRow(cellData.data.id);
      }
    },

    onChangePage(page) {
      this.$refs.vuetable.changePage(page);
    },

    async onFilterSet(data) {
      this.clearSelected();
      await this.setResourceFilter(data);
      this.refresh();
    },

    async onFilterReset() {
      this.clearSelected();
      await this.resetResourceFilter();
      this.refresh();
    },

    onToolbarUpdate() {
      this.clearSelected();
      this.refresh();
    },

    clearSelected() {
      this.$refs.vuetable.clearSelectedValues();
      this.updateSelected();
    },

    updateSelected() {
      this.selected = this.$refs.vuetable.selectedTo;
      this.selectedItems = this.$refs.vuetable.tableData.filter((item) =>
        this.selected.includes(item[this.trackBy])
      );
    },

    refresh() {
      Vue.nextTick(() => this.$refs.vuetable.refresh());
    },
  },

  render(h) {
    if (!this.parts.includes('toolbar')) {
      return h('div', {}, [this.getRenderParts(h)]);
    }

    return h('div', {}, [
      this.toolbar(h),
      h(
        'div',
        {
          class: { card: true, 'card-border': true },
        },
        this.getRenderParts(h)
      ),
    ]);
  },
});
</script>

<style lang="scss" scoped></style>
