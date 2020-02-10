<template>
  <modal name="ketcher" width="750px" height="auto" @opened="opened">
    <div class="modal-header bg-primary">
      <h4 class="modal-title">
        {{ $t('chemicals.structure._') }}
      </h4>
      <close name="ketcher"></close>
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
      <button class="btn btn-primary" @click="$modal.hide('ketcher')">
        <span class="fas fa-fw fa-times" aria-hidden="true" /> {{ $t('common.close') }}
      </button>
      <button class="btn btn-primary" @click="resolve()">
        <span class="fas fa-fw fa-check-cirle" aria-hidden="true" /> {{ $t('common.submit') }}
      </button>
    </div>
  </modal>
</template>

<script>
import * as cactus from '../../services/cactus.service';
import Close from '../modal/Close';
export default {
  name: 'Ketcher',

  components: { Close },

  data() {
    return {
      ketcher: null,
      sdf: null,
      smiles: null
    };
  },

  mounted() {},

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

    resolve() {
      const smiles = this.getSmiles();
      if (!smiles) {
        this.$toasted.error('No structure entered.');
        return;
      }

      cactus
        .inchikey(smiles)
        .then(res => this.$emit('inchikey', res))
        .catch(() => this.$toasted.error("Structure couldn't be resolved."));
    }
  }
};
</script>
