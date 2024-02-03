<template>
  <div v-if="refsLoaded" class="card-tools">
    <component
      :is="action"
      v-for="action in actions"
      :key="action"
      :action="action"
      class="me-1"
      :item="item"
      @action="onAction"
    ></component>
  </div>
</template>

<script lang="ts">
import upperFirst from 'lodash/upperFirst';
import { mapState } from 'pinia';
import { defineComponent } from 'vue';

import { useMessages, useResource } from '@/stores';

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
      default: () => {},
    },
  },

  emits: ['refresh'],

  computed: {
    ...mapState(useResource, ['refs', 'refsLoaded']),
    actions(): string[] {
      return this.refs.actions.table.filter((action) => this.canDo(action));
    },
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
      //@ts-expect-error not typed
      this[`on${upperFirst(action)}`]();
    },

    async onDelete() {
      const { id, name, item_id } = this.item;
      if (!confirm(this.$t('common.confirm.delete', { name }))) return;

      const url =
        this.module === 'chemicals' ? `chemical-items/${item_id}` : `${this.module}/${id}`;

      await this.$http.delete(url, { withLoading: true });
      this.onSuccess('deleted');
    },

    onSuccess(action: string) {
      useMessages().success(this.$t(`common.msg.${action}`, { name: this.item.name }));
      this.$emit('refresh');
    },
  },
});
</script>

<style lang="scss" scoped></style>
