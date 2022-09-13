<template>
  <modal height="auto" :name="name" width="750px" @opened="opened">
    <div class="modal-header">
      <h4 class="modal-title">
        {{ $t('chemicals.structure._') }}
      </h4>
      <close :name="name"></close>
    </div>
    <div class="modal-body p-0">
      <iframe
        id="ketcher"
        ref="ketcher"
        class="structure-sketcher"
        src="/vendor/ketcher/ketcher.html"
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
import { defineComponent } from 'vue';

import { cactusService } from '@/services';

import ModalMixin from './ModalMixin';

export default defineComponent({
  name: 'Ketcher',

  mixins: [ModalMixin],

  data() {
    return {
      ketcher: null,
      sdf: null,
      smiles: null,
    };
  },

  methods: {
    opened() {
      setTimeout(() => {
        const ketcher = this.getKetcher();
        ketcher.editor.on('change', () => {
          this.sdf = this.getKetcher().getMolfile();
          this.smiles = this.getKetcher().getSmiles();
        });
      }, 500);
    },

    getSmiles() {
      return this.getKetcher().getSmiles();
    },

    getMolfile() {
      return this.getKetcher().getMolfile();
    },

    getKetcher() {
      const ref = this.$refs.ketcher;
      return 'contentDocument' in ref
        ? ref.contentWindow.ketcher
        : document.frames['ketcher'].window.ketcher;
    },

    async resolve() {
      const smiles = this.getSmiles();
      if (!smiles) {
        this.$toasted.error(this.$t('chemicals.structure.not.entered').toString());
        return;
      }

      try {
        const res = await cactusService.inchikey(smiles);
        this.$emit('inchikey', res);
        this.close();
      } catch {
        this.$toasted.error(this.$t('chemicals.structure.not.resolved').toString());
      }
    },
  },
});
</script>
