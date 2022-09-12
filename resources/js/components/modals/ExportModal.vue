<template>
  <modal height="auto" :name="name" width="800px">
    <div class="modal-header">
      <h4 class="modal-title">{{ $t('common.export') }}</h4>
      <close :name="name"></close>
    </div>
    <div class="modal-body">
      <div class="form-group form-row justify-content-center">
        <div class="col-auto">
          <button class="btn btn-outline-danger" type="button" @click="unselectAll">
            <span class="far fa-square"></span> {{ $t('common.select.none') }}
          </button>
        </div>
        <div class="col-auto">
          <button class="btn btn-outline-success" type="button" @click="selectAll">
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
              class="custom-control-input"
              :name="option.data"
              type="checkbox"
              :value="option.data"
            />
            <label class="custom-control-label" :for="option.data">{{ option.title }}</label>
          </div>
        </div>
      </div>
    </div>
    <div class="modal-footer justify-content-center">
      <div>
        <button
          v-for="action in ['print', 'csv', 'excel']"
          :key="action"
          class="btn btn-primary"
          :disabled="!columns.length"
          type="button"
          @click.prevent="onExport(action)"
        >
          <span
            class="fas fa-fw"
            :class="action === 'print' ? 'fa-print' : `fa-file-${action}`"
            :title="$t(`common.exports.${action}`).toString()"
          ></span>
          {{ $t(`common.exports.${action}`) }}
        </button>
      </div>
    </div>
  </modal>
</template>

<script lang="ts">
import { defineComponent } from 'vue';

import { download, print } from '@/util/export';

import ListModalMixin from './ListModalMixin';
import ModalMixin from './ModalMixin';

export default defineComponent({
  name: 'ExportModal',

  mixins: [ModalMixin, ListModalMixin],

  props: {
    trackBy: {
      type: String,
      default: 'id',
    },
  },

  data() {
    return {
      columns: [],
    };
  },

  watch: {
    options: {
      handler() {
        this.selectAll();
      },
      immediate: true,
    },
  },

  methods: {
    async onExport(format: string) {
      if (!this.columns.length) {
        this.$toasted.success('Select at least one column to export');
        return;
      }

      const sort = this.sortOrder.map((item) => `${item.sortField}|${item.direction}`);

      const params = {
        ...this.appendParams,
        ...{
          export_format: format,
          export_columns: this.columns,
          [this.trackBy]: this.selected,
          sort: sort.join(','),
        },
      };

      const res = await this.$http.get(`${this.module}`, {
        ...{ params },
        ...{ responseType: format === 'print' ? 'text' : 'blob' },
      });

      if (format === 'print') print(res);
      else download(res);
    },

    selectAll() {
      this.columns = this.options.map((item) => item.data);
    },

    unselectAll() {
      this.columns = [];
    },
  },
});
</script>

<style lang="scss" scoped></style>
