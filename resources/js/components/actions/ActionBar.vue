<template>
  <div v-if="loaded" class="card-tools">
    <component
      v-for="action in actions"
      class="mr-1"
      :is="action"
      :key="action"
      :item="item"
      :action="action"
      @action="onAction"
    ></component>
  </div>
</template>

<script>
import upperFirst from 'lodash/upperFirst';
import { mapState } from 'vuex';
import Delete from './Delete';
import Download from './Download';
import Edit from './Edit';
import Run from './Run';
import Show from './Show';

export default {
  name: 'ActionBar',

  components: { Delete, Download, Edit, Run, Show },

  props: {
    item: {
      type: Object,
      default() {
        return {};
      },
    },
  },

  computed: {
    ...mapState({
      loaded(state) {
        return !!Object.keys(state[this.module].refs).length;
      },
      actions(state) {
        return state[this.module].refs.actions.table.filter((action) => this.canDo(action));
      },
    }),
  },

  methods: {
    canDo(action) {
      const { perm = {} } = this.item;
      if (action in perm) return perm[action];
      if (['detail', 'download'].includes(action)) return this.can({ action: 'show' });
      if (['show', 'edit', 'delete'].includes(action)) return this.can({ action });

      return false;
    },

    onAction(action) {
      this[`on${upperFirst(action)}`]();
    },

    async onDelete() {
      const { id, name, item_id } = this.item;
      if (!confirm(this.$t('common.confirm.delete', { name }))) return;

      const url =
        this.module === 'chemicals' ? `chemical-items/${item_id}` : `${this.module}/${id}`;

      await this.$http.delete(url);
      this.onSuccess('deleted');
    },

    onSuccess(action) {
      this.$toasted.success(this.$t(`common.msg.${action}`, { name: this.item.name }));
      this.$emit('action-success');
    },
  },
};
</script>

<style lang="scss" scoped></style>
