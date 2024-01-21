<template>
  <modal height="auto" :name="name" width="750px">
    <div class="modal-header">
      <h4 class="modal-title">
        {{ $t('chemicals.structure._') }}
      </h4>
      <close :name="name"></close>
    </div>
    <div class="modal-body p-0">
      <iframe
        id="ketcher"
        ref="ketcherRef"
        class="structure-sketcher"
        src="/vendor/ketcher/index.html"
      />
    </div>
    <div class="modal-footer">
      <button class="btn btn-outline-secondary" type="button" @click.stop="close()">
        <span class="fas fa-fw fa-times" :title="$t('common.cancel').toString()"></span>
        {{ $t('common.cancel') }}
      </button>
      <button class="btn btn-primary" type="button" @click="resolve()">
        <span aria-hidden="true" class="fas fa-fw fa-check-circle" />
        {{ $t('common.submit') }}
      </button>
    </div>
  </modal>
</template>

<script lang="ts">
import type { Ketcher } from 'ketcher-core';
import { defineComponent, ref } from 'vue';

import ModalMixin from './ModalMixin';

export default defineComponent({
  name: 'Ketcher',

  mixins: [ModalMixin],

  setup() {
    const ketcherRef = ref<InstanceType<typeof HTMLFormElement>>();
    const getKetcher = (): Ketcher | null => {
      return ketcherRef.value?.contentWindow.ketcher;
    };

    return {
      ketcherRef,
      getKetcher,
    };
  },

  methods: {
    async resolve() {
      try {
        const InChIKey = await this.getKetcher()?.getInChIKey();
        this.$emit('inchikey', InChIKey);
        this.close();
      } catch (err) {
        this.$toasted.error(this.$t('chemicals.structure.not.resolved').toString());
      }
    },
  },
});
</script>
