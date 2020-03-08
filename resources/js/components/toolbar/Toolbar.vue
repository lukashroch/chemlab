<template>
  <div v-if="loaded" class="card-body">
    <div class="row">
      <div class="col-auto toolbar-group">
        <template v-for="(action, idx) in ['create', 'run', 'show', 'edit']">
          <component
            :is="action"
            v-if="canDo(action) && actions.includes(action)"
            :key="idx"
            :disabled="selectedItems.length !== 1"
            @action="onAction"
          ></component>
        </template>
      </div>
      <div class="col-auto">
        <div class="row d-flex toolbar-group">
          <template v-if="actions.includes('export')">
            <open-modal
              name="toolbar-export"
              :label="$t('common.export')"
              icon="fas fa-file-export"
            ></open-modal>
            <export-modal
              name="toolbar-export"
              :selected="selected"
              :options="columns"
              :append-params="appendParams"
              :sort-order="sortOrder"
              :track-by="trackBy"
            ></export-modal>
          </template>
          <template v-if="module === 'chemicals'">
            <open-modal
              name="toolbar-transfer"
              :label="$t('common.move')"
              icon="fas fa-exchange-alt"
            ></open-modal>
            <transfer-modal
              name="toolbar-transfer"
              :selected="selected"
              :options="refs.filter.store"
              @action="onAction"
            ></transfer-modal>
          </template>
        </div>
      </div>
      <div class="col-auto ml-auto toolbar-group">
        <template v-for="(action, idx) in ['delete']">
          <component
            :is="action"
            v-if="can({ action }) && actions.includes(action)"
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
import HasLoading from '../../mixins/HasLoading';
import Create from './Create';
import Delete from './Delete';
import Edit from './Edit';
import ExportModal from '../modals/ExportModal';
import TransferModal from '../modals/ChemicalMove';
import OpenModal from './OpenModal';
import Run from './Run';
import Show from './Show';

export default {
  name: 'Toolbar',

  components: {
    Create,
    Delete,
    Edit,
    TransferModal,
    ExportModal,
    OpenModal,
    Run,
    Show
  },

  mixins: [HasLoading],

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
    },
    selectedItems: {
      type: Array,
      required: true
    },
    trackBy: {
      type: String,
      default: 'id'
    }
  },

  computed: {
    ...mapState({
      loaded(state) {
        return !!Object.keys(state[this.module].refs).length;
      },
      actions(state) {
        return state[this.module].refs.actions?.toolbar ?? [];
      },
      columns(state) {
        return state[this.module].refs.columns ?? [];
      },
      refs(state) {
        return state[this.module].refs;
      }
    })
  },

  methods: {
    canDo(action) {
      if (['run'].includes(action)) return this.can({ action: 'create' });
      return this.can({ action });
    },

    getOneSelected(key = 'id') {
      if (this.selectedItems.length !== 1) {
        this.$toasted.notice(this.$t('Select one item to view/edit details.'));
        return false;
      }
      return this.selectedItems[0][key];
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

    async onRun() {
      await this.withLoading(this.$http.post(this.module, {}, { withErr: true }));
      this.$toasted.success(this.$t(`${this.module}.done`));
      this.onDraw();
    },

    async onDelete() {
      const id = this.getAtLeastOneSelected();
      if (id === false) return;

      if (!confirm(this.$t('common.confirm.multi.delete', { count: id.length }))) return;

      await this.$http.delete(this.module === 'chemicals' ? 'chemical-items' : this.module, {
        params: { id }
      });
      this.$toasted.success(this.$t('common.msg.multi.deleted'));
      this.onDraw();
    }
  }
};
</script>

<style lang="scss" scoped></style>
