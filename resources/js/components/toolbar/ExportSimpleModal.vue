<template>
  <modal name="toolbar-export" height="200px">
    <div class="modal-header bg-primary">
      <h4 class="modal-title">{{ $t('common.action.export') }}</h4>
      <close name="toolbar-export"></close>
    </div>
    <div class="modal-body d-flex justify-content-center">
      <div class="my-3">
        <button type="button" class="btn btn-lg btn-primary mr-3" @click.stop="onExport('csv')">
          <span class="fas fa-file-csv" :title="$t('common.exports.csv')"></span>
          {{ $t('common.exports.csv') }}
        </button>
        <button type="button" class="btn btn-lg btn-primary" @click.stop="onExport('xlsx')">
          <span class="fas fa-file-excel" :title="$t('common.exports.excel')"></span>
          {{ $t('common.exports.excel') }}
        </button>
      </div>
    </div>
  </modal>
</template>

<script>
import { download } from '../../utilities/export';
import Close from '../modal/Close';

export default {
  name: 'ExportSimpleModal',

  components: { Close },

  methods: {
    async onExport(format) {
      const res = await this.$http.get(`${this.module}/${this.$route.params.id}/export/${format}`, {
        responseType: 'blob'
      });
      download(res);
    }
  }
};
</script>

<style scoped></style>
