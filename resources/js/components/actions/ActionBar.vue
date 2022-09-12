<template>
  <div v-if="loaded" class="card-tools">
    <component
      :is="action"
      v-for="action in actions"
      :key="action"
      :action="action"
      class="mr-1"
      :item="item"
      @action="onAction"
    ></component>
  </div>
</template>

<script lang="ts">
import upperFirst from 'lodash/upperFirst';
import { defineComponent } from 'vue';
import { mapState } from 'vuex';

import Delete from './Delete.vue';
import Download from './Download.vue';
import Edit from './Edit.vue';
import Run from './Run.vue';
import Show from './Show.vue';

export default defineComponent({
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
    canDo(action: string) {
      const { perm = {} } = this.item;
      if (action in perm) return perm[action];
      if (['detail', 'download'].includes(action)) return this.can({ action: 'show' });
      if (['show', 'edit', 'delete'].includes(action)) return this.can({ action });

      return false;
    },

    onAction(action: string) {
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

    onSuccess(action: string) {
      this.$toasted.success(this.$t(`common.msg.${action}`, { name: this.item.name }));
      this.$emit('action-success');
    },
  },
});
</script>

<style lang="scss" scoped></style>
