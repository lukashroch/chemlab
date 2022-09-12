<script lang="ts">
import { mapActions } from 'pinia';
import { defineComponent } from 'vue';

import ActionBar from '@/components/actions/ActionBar.vue';
import { useResource } from '@/stores';

import AdminTable from './AdminTable.vue';
import defs from './ResourceDefs';

export default defineComponent({
  name: 'ResourceTable',

  components: { ActionBar, AdminTable },

  props: {
    parts: {
      type: Array,
      default() {
        return ['toolbar', 'filter', 'table', 'pagination'];
      },
    },
  },

  computed: {
    fields() {
      return this.module in defs ? defs[this.module].fields : [];
    },
    sortOrder() {
      return this.module in defs ? defs[this.module].sortOrder : [];
    },
  },

  watch: {
    async $route() {
      await this.request();
    },
  },

  async created() {
    await this.request();
  },

  methods: {
    ...mapActions(useResource, ['request']),

    onActionSuccess() {
      this.$refs.table.refresh();
    },
  },

  render(h) {
    const slots = {};
    slots.actions = (props) => {
      return h('action-bar', {
        props: {
          item: props.rowData,
        },
        on: {
          'action-success': this.onActionSuccess,
        },
      });
    };

    if (this.$vnode.data.scopedSlots) {
      Object.keys(this.$vnode.data.scopedSlots).forEach((slot) => {
        if (typeof this.$vnode.data.scopedSlots[slot] === 'function')
          slots[slot] = this.$vnode.data.scopedSlots[slot];
      });
    }

    return h('admin-table', {
      name: 'table',
      ref: 'table',
      props: {
        fields: this.fields,
        sortOrder: this.sortOrder,
        filterData: Array.isArray(this.filterData) ? {} : this.filterData,
        parts: this.parts,
      },
      scopedSlots: slots,
    });
  },
});
</script>

<style lang="scss" scoped></style>
