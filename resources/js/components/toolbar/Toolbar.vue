<template>
  <div v-if="loaded" class="card-body">
    <div class="row">
      <div class="col-auto toolbar-group">
        <template v-for="(action, idx) in ['create', 'show', 'detail', 'edit']">
          <component
            :is="action"
            v-if="(action !== 'edit' || canDo(action)) && actions.includes(action)"
            :key="idx"
            :selected="selected"
            :disabled="selected.length !== 1"
            @action="onAction"
          ></component>
        </template>
      </div>
      <div class="col-auto">
        <div class="row d-flex toolbar-group">
          <template v-if="canDo('show') && actions.includes('export')">
            <export></export>
            <export-modal
              :selected="selected"
              :options="columns"
              :append-params="appendParams"
              :sort-order="sortOrder"
            ></export-modal>
          </template>
        </div>
      </div>
      <div class="col-auto ml-auto toolbar-group">
        <template v-for="(action, idx) in ['delete']">
          <component
            :is="action"
            v-if="canDo(action) && actions.includes(action)"
            :key="idx"
            :disabled="!selected.length"
            @action="onAction"
          ></component>
        </template>
      </div>
    </div>
  </div>
</template>

<script>
import upperFirst from 'lodash/upperFirst';
import { mapState } from 'vuex';
import Create from './Create';
import Delete from './Delete';
import Edit from './Edit';
import Export from './Export';
import ExportModal from './ExportModal';
import Show from './Show';

export default {
  name: 'Toolbar',

  components: {
    Create,
    Delete,
    Edit,
    Export,
    ExportModal,
    Show
  },

  props: {
    appendParams: {
      type: Object,
      required: true
    },
    sortOrder: {
      type: Array,
      default() {
        return [];
      }
    },
    selected: {
      type: Array,
      required: true
    }
  },

  computed: {
    ...mapState({
      loaded(state) {
        return !!Object.keys(state[this.module].refs).length;
      },
      actions(state) {
        return state[this.module].refs.actions.toolbar;
      },
      columns(state) {
        return state[this.module].refs.columns;
      }
    })
  },

  methods: {
    canDo(action) {
      return this.can(`${this.module}-${action}`);
    },

    onAction(action) {
      this[`on${upperFirst(action)}`]();
    },

    onShow() {
      const id = this.getOneSelected();
      if (id === false) return;

      this.$router.push({ name: `${this.module}.show`, params: { id } });
    },

    onEdit() {
      const id = this.getOneSelected();
      if (id === false) return;

      this.$router.push({ name: `${this.module}.edit`, params: { id } });
    },

    onStatus() {
      this.onDraw();
    },

    async onDelete() {
      const id = this.getAtLeastOneSelected();
      if (id === false) return;

      if (!confirm(this.$t('common.action.confirm.multi.delete', { count: id.length }))) return;

      await this.$http.delete(this.module, { params: { id } });
      this.$toasted.success(this.$t('common.msg.multi.deleted'));
      this.onDraw();
    },

    getOneSelected() {
      if (this.selected.length !== 1) {
        this.$toasted.notice(this.$t('Select one item to view/edit details.'));
        return false;
      }
      return this.selected[0];
    },

    getAtLeastOneSelected() {
      if (!this.selected.length) {
        this.$toasted.notice(this.$t('Select at least one item.'));
        return false;
      }
      return this.selected;
    },

    onDraw() {
      this.$emit('toolbar-update');
    }
  }
};
</script>

<style scoped></style>
