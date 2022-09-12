<template>
  <span>
    <button
      class="btn btn-sm btn-primary"
      :title="$t('common.export')"
      type="button"
      @click="onClick"
    >
      <span class="fas fa-fw fa-file-export" :title="$t('common.export')"></span>
    </button>
    <modal height="200px" name="action-export">
      <div class="modal-header">
        <h4 class="modal-title">{{ $t('common.export') }}</h4>
        <div class="card-tools">
          <button
            :aria-label="$t('common.close')"
            class="close"
            type="button"
            @click="$modal.hide('action-export')"
          >
            <span :aria-label="$t('common.close')" class="fas fa-times"></span>
          </button>
        </div>
      </div>
      <div class="modal-body d-flex justify-content-center">
        <div class="my-3">
          <button class="btn btn-lg btn-primary mr-3" type="button" @click.stop="onExport('csv')">
            <span class="fas fa-file-csv" :title="$t('common.exports.csv')"></span>
            {{ $t('common.exports.csv') }}
          </button>
          <button class="btn btn-lg btn-primary" type="button" @click.stop="onExport('xlsx')">
            <span class="fas fa-file-excel" :title="$t('common.exports.excel')"></span>
            {{ $t('common.exports.excel') }}
          </button>
        </div>
      </div>
    </modal>
  </span>
</template>

<script>
import { download } from '@/utilities/export';

import ActionMixin from './ActionMixin';

export default {
  name: 'Export',

  mixins: [ActionMixin],

  methods: {
    onClick() {
      this.$modal.show('action-export');
    },

    async onExport(format) {
      const res = await this.$http.post(
        `${this.module}/${this.item.id}/export/${format}`,
        {},
        { responseType: 'blob' }
      );
      download(res);
    },
  },
};
</script>

<style lang="scss" scoped></style>
