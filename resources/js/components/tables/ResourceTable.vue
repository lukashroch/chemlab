<script>
import ActionBar from '../actions/ActionBar';
import AdminTable from './AdminTable';
import defs from './ResourceDefs';

export default {
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
      return defs[this.module].fields;
    },
    sortOrder() {
      return defs[this.module].sortOrder;
    },
  },

  watch: {
    $route(to) {
      const { module } = to.meta;
      this.$store.dispatch(`${module}/request`);
    },
  },

  async created() {
    await this.$store.dispatch(`${this.module}/request`);
  },

  methods: {
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
};
</script>

<style lang="scss" scoped></style>
