<template>
  <layout v-if="structureLoaded" v-bind="{ id, entry }">
    <div class="tab-pane active">
      <div class="card-body">
        <template v-if="entry.structure.sdf">
          <img v-if="svg" class="structure-render" :src="svg" />
          <iframe
            ref="ketcherRef"
            class="structure-sketcher d-none"
            src="/vendor/ketcher/index.html"
            @message="test"
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
import type { Ketcher } from 'ketcher-core';
import { defineComponent, ref } from 'vue';

import { formMixin } from '@/components/entry';
import { useMessages } from '@/stores';
import { createForm } from '@/util';

export default defineComponent({
  name: 'ChemicalStructure',

  mixins: [formMixin],

  setup() {
    const svg = ref<string>('');
    const ketcherRef = ref<InstanceType<typeof HTMLFormElement>>();
    const getKetcher = (): Ketcher | null => {
      return ketcherRef.value?.contentWindow.ketcher;
    };

    const test = (event: any) => {
      console.log('test');
      console.log(event);
    };

    return {
      ketcherRef,
      getKetcher,
      svg,
      test,
    };
  },

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
      handler(val) {
        setTimeout(async () => {
          if (!val) return;

          await this.drawStructure(val);
        }, 750);
      },
      deep: true,
    },
  },

  methods: {
    async drawStructure(structure: string) {
      const blob = await this.getKetcher()?.generateImage(structure, {
        bondThickness: 2,
        outputFormat: 'svg',
      });
      if (!blob) return;

      this.svg = URL.createObjectURL(blob);
    },

    async toClipboard(data: string) {
      await navigator.clipboard.writeText(data);
      useMessages().info('Structure data copied to clipboard!');
    },
  },
});
</script>

<style scoped lang="scss"></style>
