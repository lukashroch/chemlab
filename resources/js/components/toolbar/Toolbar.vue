<template>
  <div v-if="refsLoaded" class="card bg-white mb-4">
    <div class="card-body">
      <div class="row">
        <div class="col-auto toolbar-group">
          <template v-for="action in ['create', 'run', 'show', 'edit']">
            <component
              :is="action"
              v-if="canDo(action) && actions.includes(action)"
              :key="action"
              :action="action"
              :disabled="selected.length !== 1"
              @action="onAction"
            ></component>
          </template>
        </div>
        <div class="col-auto">
          <div class="d-flex">
            <export
              v-if="actions.includes('export')"
              v-bind="{ filter, selected, sort, options: columns }"
            ></export>
            <chemical-move
              v-if="module === 'chemicals'"
              :options="refs.filter?.store ?? []"
              :selected="selected"
              @refresh="refresh"
            ></chemical-move>
          </div>
        </div>
        <div class="col-auto ms-auto toolbar-group">
          <template v-for="action in ['delete']">
            <component
              :is="action"
              v-if="can({ action }) && actions.includes(action)"
              :key="action"
              :disabled="!selected.length"
              @action="onAction"
            ></component>
          </template>
        </div>
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import type { PropType } from 'vue';
import upperFirst from 'lodash/upperFirst';
import { mapState } from 'pinia';
import { defineComponent } from 'vue';

import type { Filter, Option } from '@/stores';
import { ChemicalMove } from '@/components/modals';
import { useMessages, useResource } from '@/stores';

import Create from './Create.vue';
import Delete from './Delete.vue';
import Edit from './Edit.vue';
import Export from './Export.vue';
import Run from './Run.vue';
import Show from './Show.vue';

export default defineComponent({
  name: 'Toolbar',

  components: {
    Create,
    Delete,
    Edit,
    ChemicalMove,
    Export,
    Run,
    Show,
  },

  props: {
    api: {
      type: String,
      required: true,
    },
    filter: {
      type: Object as PropType<Filter>,
      default: () => ({}),
    },
    selected: {
      type: Array as PropType<number[]>,
      required: true,
    },
    sort: {
      type: String,
    },
  },

  emits: ['refresh'],

  computed: {
    ...mapState(useResource, ['refs', 'refsLoaded']),
    actions(): string[] {
      return this.refs.actions.toolbar ?? [];
    },
    columns(): Option[] {
      return this.refs.columns ?? [];
    },
  },

  methods: {
    canDo(action: string) {
      if (['run'].includes(action)) return this.can({ action: 'create' });

      if (
        ['create', 'show', 'edit'].includes(action) &&
        !this.$router.hasRoute(`${this.module}.${action}`)
      )
        return false;

      return this.can({ action });
    },

    getOneSelected() {
      if (this.selected.length !== 1) {
        useMessages().info(this.$t('Select one item to view/edit details.'));
        return false;
      }
      return this.selected[0];
    },

    getAtLeastOneSelected() {
      if (!this.selected.length) {
        useMessages().info(this.$t('Select at least one item.'));
        return false;
      }
      return this.selected;
    },

    refresh() {
      this.$emit('refresh');
    },

    onAction(action: string) {
      //@ts-expect-error types
      this[`on${upperFirst(action)}`]();
    },

    async onShow() {
      const id = this.getOneSelected();
      if (id === false) return;

      await this.$router.push({ name: `${this.module}.show`, params: { id } });
    },

    async onEdit() {
      const id = this.getOneSelected();
      if (id === false) return;

      await this.$router.push({ name: `${this.module}.edit`, params: { id } });
    },

    async onRun() {
      await this.$http.post(this.module, {}, { withLoading: true });
      useMessages().success(this.$t(`${this.module}.done`));
      this.refresh();
    },

    async onDelete() {
      const id = this.getAtLeastOneSelected();
      if (id === false) return;

      if (!confirm(this.$t('common.confirm.multi.delete', { count: id.length }))) return;

      await this.$http.delete(this.module === 'chemicals' ? 'chemical-items' : this.module, {
        params: { id },
        withLoading: true,
      });
      useMessages().success(this.$t('common.msg.multi.deleted'));
      this.refresh();
    },
  },
});
</script>

<style lang="scss" scoped></style>
