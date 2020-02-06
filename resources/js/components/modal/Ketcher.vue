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
        src="/vendor/ketcher-v2/ketcher.html"
      />
    </div>
    <div class="modal-footer">
      <button class="btn btn-primary" @click="getSmiles()">
        <span class="fas fa-submit" aria-hidden="true" /> {{ $t('common.submit') }}
      </button>
      <button class="btn btn-primary" @click="getMolfile()">
        <span class="fas fa-submit" aria-hidden="true" /> {{ $t('common.submit') }}
      </button>
    </div>
  </modal>
</template>

<script>
import Close from '../modal/Close';
export default {
  name: 'Ketcher',

  components: { Close },

  props: {
    inchi: {
      type: null,
      default: null
    }
  },

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
          console.log('changeeeeed!');
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
    }
  }
};
</script>

<style lang="sass"></style>
