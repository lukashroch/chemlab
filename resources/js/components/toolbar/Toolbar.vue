<template>
  <div v-if="refsLoaded" class="card-body">
    <div class="row">
      <div class="col-auto toolbar-group">
        <template v-for="action in ['create', 'run', 'show', 'edit']">
          <component
            :is="action"
            v-if="canDo(action) && actions.includes(action)"
            :key="action"
            :disabled="selectedItems.length !== 1"
            @action="onAction"
          ></component>
        </template>
      </div>
      <div class="col-auto">
        <div class="row d-flex toolbar-group">
          <template v-if="actions.includes('export')">
            <open-modal
              icon="fas fa-file-export"
              :label="$t('common.export').toString()"
              name="toolbar-export"
            ></open-modal>
            <export-modal
              :append-params="appendParams"
              name="toolbar-export"
              :options="columns"
              :selected="selected"
              :sort-order="sortOrder"
              :track-by="trackBy"
            ></export-modal>
          </template>
          <template v-if="module === 'chemicals'">
            <open-modal
              icon="fas fa-exchange-alt"
              :label="$t('common.move').toString()"
              name="toolbar-transfer"
            ></open-modal>
            <chemical-move
              name="toolbar-transfer"
              :options="refs.filter?.store ?? []"
              :selected="selected"
              @action="onAction"
            ></chemical-move>
          </template>
        </div>
      </div>
      <div class="col-auto ml-auto toolbar-group">
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
</template>

<script lang="ts">
import upperFirst from 'lodash/upperFirst';
import { mapState } from 'pinia';
import { defineComponent } from 'vue';

import type { Option } from '@/stores';
import { ChemicalMove, ExportModal } from '@/components/modals';
import { useResource } from '@/stores';

import Create from './Create.vue';
import Delete from './Delete.vue';
import Edit from './Edit.vue';
import OpenModal from './OpenModal.vue';
import Run from './Run.vue';
import Show from './Show.vue';

export default defineComponent({
  name: 'Toolbar',

  components: {
    Create,
    Delete,
    Edit,
    ChemicalMove,
    ExportModal,
    OpenModal,
    Run,
    Show,
  },

  props: {
    appendParams: {
      type: Object,
      required: true,
    },
    sortOrder: {
      type: Array,
      default() {
        return [];
      },
    },
    selected: {
      type: Array,
      required: true,
    },
    selectedItems: {
      type: Array,
      required: true,
    },
    trackBy: {
      type: String,
      default: 'id',
    },
  },

  computed: {
    ...mapState(useResource, ['refs', 'refsLoaded']),
    actions(): string[] {
      return this.refs.actions.toolbar || [];
    },
    columns(): Option[] {
      return this.refs.columns || [];
    },
  },

  methods: {
    canDo(action: string) {
      if (['run'].includes(action)) return this.can({ action: 'create' });
      return this.can({ action });
    },

    getOneSelected(key = 'id') {
      if (this.selectedItems.length !== 1) {
        this.$toasted.info(this.$t('Select one item to view/edit details.').toString());
        return false;
      }
      return this.selectedItems[0][key];
    },

    getAtLeastOneSelected() {
      if (!this.selected.length) {
        this.$toasted.info(this.$t('Select at least one item.').toString());
        return false;
      }
      return this.selected;
    },

    onDraw() {
      this.$emit('toolbar-update');
    },

    onAction(action: string) {
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
      this.$toasted.success(this.$t(`${this.module}.done`).toString());
      this.onDraw();
    },

    async onDelete() {
      const id = this.getAtLeastOneSelected();
      if (id === false) return;

      if (!confirm(this.$t('common.confirm.multi.delete', { count: id.length }).toString())) return;

      await this.$http.delete(this.module === 'chemicals' ? 'chemical-items' : this.module, {
        params: { id },
      });
      this.$toasted.success(this.$t('common.msg.multi.deleted').toString());
      this.onDraw();
    },
  },
});
</script>

<style lang="scss" scoped></style>
