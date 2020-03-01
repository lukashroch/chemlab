<template>
  <modal :name="name" width="750px" height="auto" @opened="opened">
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
      <button type="button" class="btn btn-outline-secondary" @click.stop="close()">
        <span class="fas fa-fw fa-times" :title="$t('common.cancel')"></span>
        {{ $t('common.cancel') }}
      </button>
      <button type="button" class="btn btn-primary" @click="resolve()">
        <span class="fas fa-fw fa-check-circle" aria-hidden="true" />
        {{ $t('common.submit') }}
      </button>
    </div>
  </modal>
</template>

<script>
import * as cactus from '../../services/cactus.service';
import ModalMixin from './ModalMixin';
export default {
  name: 'Ketcher',

  mixins: [ModalMixin],

  data() {
    return {
      ketcher: null,
      sdf: null,
      smiles: null
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
        this.$toasted.error(this.$t('chemicals.structure.not.entered'));
        return;
      }

      try {
        const res = await cactus.inchikey(smiles);
        this.$emit('inchikey', res);
        this.close();
      } catch {
        this.$toasted.error(this.$t('chemicals.structure.not.resolved'));
      }
    }
  }
};
</script>
