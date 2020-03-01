<template>
  <modal :name="name" height="auto" width="800px">
    <div class="modal-header bg-primary">
      <h4 class="modal-title">{{ $t('common.action.export') }}</h4>
      <close :name="name"></close>
    </div>
    <div class="modal-body">
      <div class="form-group form-row justify-content-center">
        <div class="col-auto">
          <button type="button" class="btn btn-outline-danger" @click="unselectAll">
            <span class="far fa-square"></span> {{ $t('common.select.none') }}
          </button>
        </div>
        <div class="col-auto">
          <button type="button" class="btn btn-outline-success" @click="selectAll">
            <span class="far fa-check-square"></span> {{ $t('common.select.all') }}
          </button>
        </div>
      </div>
      <div class="form-group form-row">
        <div v-for="option in options" :key="option.data" class="form-check col-6 col-md-4 mb-2">
          <div class="custom-control custom-checkbox">
            <input
              :id="option.data"
              v-model="columns"
              type="checkbox"
              :name="option.data"
              :value="option.data"
              class="custom-control-input"
            />
            <label :for="option.data" class="custom-control-label">{{ option.title }}</label>
          </div>
        </div>
      </div>
    </div>
    <div class="modal-footer justify-content-center">
      <div>
        <button
          v-for="action in ['print', 'csv', 'excel']"
          :key="action"
          type="button"
          class="btn btn-primary"
          :disabled="!columns.length"
          @click.prevent="onExport(action)"
        >
          <span
            class="fas fa-fw"
            :class="action === 'print' ? 'fa-print' : `fa-file-${action}`"
            :title="$t(`common.exports.${action}`)"
          ></span>
          {{ $t(`common.exports.${action}`) }}
        </button>
      </div>
    </div>
  </modal>
</template>

<script>
import ModalMixin from './ModalMixin';
import ListModalMixin from './ListModalMixin';
import { download, print } from '../../utilities/export';

export default {
  name: 'ExportModal',

  mixins: [ModalMixin, ListModalMixin],

  props: {
    trackBy: {
      type: String,
      default: 'id'
    }
  },

  data() {
    return {
      columns: []
    };
  },

  watch: {
    options: {
      handler() {
        this.selectAll();
      },
      immediate: true
    }
  },

  methods: {
    async onExport(format) {
      if (!this.columns.length) {
        this.$toasted.success('Select at least one column to export');
        return;
      }

      const sort = this.sortOrder.map(item => `${item.sortField}|${item.direction}`);

      const params = {
        ...this.appendParams,
        ...{
          export_format: format,
          export_columns: this.columns,
          [this.trackBy]: this.selected,
          sort: sort.join(',')
        }
      };

      const res = await this.$http.get(`${this.$route.meta.module}`, {
        ...{ params },
        ...{ responseType: format === 'print' ? 'text' : 'blob' }
      });

      if (format === 'print') print(res);
      else download(res);
    },

    selectAll() {
      this.columns = this.options.map(item => item.data);
    },

    unselectAll() {
      this.columns = [];
    }
  }
};
</script>

<style lang="scss" scoped></style>
