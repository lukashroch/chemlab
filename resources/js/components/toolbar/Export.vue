<template>
  <button class="btn btn-primary me-1" @click="open">
    <span class="fas fa-file-export"></span>
    {{ $t('common.export') }}
  </button>
  <vue-final-modal
    v-model="dialog"
    class="d-flex justify-content-center align-items-center"
    content-class="bg-white rounded export-dialog"
  >
    <div class="d-flex justify-content-between align-items-center px-4 py-2 border border-bottom">
      <h5 class="mb-0">{{ $t('common.export') }}</h5>
      <button
        :aria-label="$t('common.close')"
        class="btn"
        :title="$t('common.close')"
        type="button"
        @click="close"
      >
        <span :aria-label="$t('common.close')" class="fas fa-lg fa-times"></span>
      </button>
    </div>
    <div class="p-4">
      <div class="row mb-3 justify-content-center">
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
      <div class="row">
        <div v-for="option in options" :key="option.data" class="form-check col-6 col-md-4 mb-2">
          <div class="form-check">
            <input
              :id="option.data"
              v-model="columns"
              class="form-check-input"
              :name="option.data"
              type="checkbox"
              :value="option.data"
            />
            <label class="form-check-label" :for="option.data">{{ option.title }}</label>
          </div>
        </div>
      </div>
    </div>
    <div class="d-flex justify-content-center p-4">
      <div class="d-flex flex-row gap-2">
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
            :title="$t(`common.exports.${action}`)"
          ></span>
          {{ $t(`common.exports.${action}`) }}
        </button>
      </div>
    </div>
  </vue-final-modal>
</template>

<script lang="ts">
import type { PropType } from 'vue';
import { defineComponent, ref } from 'vue';
import { VueFinalModal } from 'vue-final-modal';

import { type Filter, type Option, useMessages } from '@/stores';
import { download, print } from '@/util/export';

export default defineComponent({
  name: 'Export',

  components: { VueFinalModal },

  props: {
    filter: {
      type: Object as PropType<Filter>,
      default: () => ({}),
    },
    disabled: {
      type: Boolean,
      default: false,
    },
    options: {
      type: Array as PropType<Option[]>,
      default: () => [],
    },
    selected: {
      type: Array as PropType<number[]>,
      required: true,
    },
    sort: {
      type: String,
    },
  },

  setup() {
    const dialog = ref(false);
    const columns = ref<(string | number)[]>([]);

    function close() {
      dialog.value = false;
    }

    function open() {
      dialog.value = true;
    }

    return {
      columns,
      dialog,
      close,
      open,
    };
  },

  watch: {
    dialog: {
      handler(val) {
        if (!val) return;

        this.selectAll();
      },
      immediate: true,
    },
  },

  methods: {
    async onExport(format: string) {
      if (!this.columns.length) {
        useMessages().warning('Select at least one column to export');
        return;
      }

      const params = {
        ...this.filter,
        export_format: format,
        export_columns: this.columns,
        id: this.selected,
        sort: this.sort,
      };

      const res = await this.$http.get(`${this.module}`, {
        ...{ params },
        responseType: format === 'print' ? 'text' : 'blob',
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

<style lang="scss">
.export-dialog {
  max-width: 700px;
  max-height: 80vh;
}
</style>
