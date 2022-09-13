<template>
  <layout v-if="structureLoaded" v-bind="{ id, entry }">
    <div class="tab-pane active">
      <div class="card-body">
        <template v-if="entry.structure.sdf">
          <div ref="molecule" class="structure-render"></div>
          <iframe
            ref="ketcher"
            class="structure-sketcher d-none"
            src="/vendor/ketcher/ketcher.html"
          />
          <hr class="my-4" />
        </template>
        <dl class="row">
          <dt class="col-sm-2">{{ $t('chemicals.structure.inchi') }}</dt>
          <dd class="col-sm-10">
            <div class="border rounded structure-data">
              <div class="clipboard" @click="toClipboard('inchi')">
                <span class="fa fa-fw fa-clipboard"></span>
              </div>
              <code>{{ entry.structure.inchi }}</code>
            </div>
          </dd>
          <dt class="col-sm-2">{{ $t('chemicals.structure.inchikey') }}</dt>
          <dd class="col-sm-10">
            <div class="border rounded structure-data">
              <div class="clipboard" @click="toClipboard('inchikey')">
                <span class="fa fa-fw fa-clipboard"></span>
              </div>
              <code>{{ entry.structure.inchikey }}</code>
            </div>
          </dd>
          <dt class="col-sm-2">{{ $t('chemicals.structure.smiles') }}</dt>
          <dd class="col-sm-10">
            <div class="border rounded structure-data">
              <div class="clipboard" @click="toClipboard('smiles')">
                <span class="fa fa-fw fa-clipboard"></span>
              </div>
              <code>{{ entry.structure.smiles }}</code>
            </div>
          </dd>
          <dt class="col-sm-2">{{ $t('chemicals.structure.sdf') }}</dt>
          <dd class="col-sm-10">
            <div class="border rounded structure-data">
              <div class="clipboard" @click="toClipboard('sdf')">
                <span class="fa fa-fw fa-clipboard"></span>
              </div>
              <code>{{ entry.structure.sdf }}</code>
            </div>
          </dd>
        </dl>
      </div>
    </div>
  </layout>
</template>

<script lang="ts">
import { defineComponent } from 'vue';

import { formMixin } from '@/components/entry';
import { createForm } from '@/util';

export default defineComponent({
  name: 'ChemicalStructure',

  mixins: [formMixin],

  data() {
    return {
      form: createForm({
        id: null,
        name: null,
        iupac: null,
        synonym: null,
        brand_id: null,
        catalog_id: null,
        cas: null,
        pubchem: null,
        chemspider: null,
        mw: null,
        formula: null,
        description: null,
        structure: {
          inchi: null,
          inchikey: null,
          sds: null,
          smiles: null,
        },
        signal_word: null,
        h: [],
        p: [],
        r: [],
        s: [],
        symbol: [],
      }),
      ketcher: null,
      sdf: null,
      smiles: null,
    };
  },

  computed: {
    structureLoaded() {
      const { structure } = this.entry;
      return structure && !!Object.keys(structure).length;
    },
  },

  watch: {
    'entry.structure.sdf': {
      handler() {
        setTimeout(() => {
          const sdf = this.entry?.structure?.sdf;
          if (!sdf) return;

          const ketcher = this.getKetcher();
          ketcher.showMolfile(this.$refs.molecule, this.entry.structure.sdf, {
            bondLength: 20,
            autoScale: true,
            autoScaleMargin: 35,
            ignoreMouseEvents: true,
            atomColoring: true,
          });
        }, 500);
      },
      deep: true,
    },
  },

  methods: {
    getKetcher() {
      const ref = this.$refs.ketcher;
      return ref && 'contentDocument' in ref
        ? ref.contentWindow.ketcher
        : document.frames['ketcher'].window.ketcher;
    },

    toClipboard(item) {
      this.$copyText(this.entry.structure[item]).then(
        () => this.$toasted.success('Structure data copied to clipboard!'),
        () => this.$toasted.error('Cannot copy structure data!')
      );
    },
  },
});
</script>

<style scoped lang="scss"></style>
