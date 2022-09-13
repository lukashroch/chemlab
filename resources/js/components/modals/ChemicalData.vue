<template>
  <modal height="auto" :name="name" :pivot-y="0.25" :scrollable="true" @before-open="beforeOpen">
    <div class="modal-header">
      <h4 class="modal-title">{{ $t('chemicals.data._') }}</h4>
      <close :name="name"></close>
    </div>
    <div class="modal-body">
      <form @submit.prevent="onSearch">
        <div class="form-group form-row">
          <label class="col-form-label col-3" for="source">{{ $t('chemicals.data.source') }}</label>
          <div class="col">
            <multiselect
              v-model="sources.selected"
              :options="sources.list"
              :placeholder="$t('chemicals.data.source').toString()"
            >
            </multiselect>
            <small v-for="source in hints" :key="source.id" class="form-text mb-0">
              <span class="fas fa-fw fa-info"></span> {{ source.hint }}
            </small>
          </div>
        </div>
        <div class="form-group form-row">
          <label class="col-form-label col-3" for="search">{{ $t('chemicals.data.id') }}</label>
          <div class="col">
            <div class="input-group">
              <input
                id="search"
                v-model="search"
                class="form-control"
                name="search"
                :placeholder="$t('chemicals.data.id').toString()"
                type="text"
              />
              <div class="input-group-append">
                <button class="btn btn-primary" :disabled="!search" type="submit">
                  <span class="fas fa-fw fa-search"></span> {{ $t('common.search._') }}
                </button>
              </div>
            </div>
          </div>
        </div>
        <div class="">
          <h5 class="cursor" @click="showOptions = !showOptions">
            <span
              class="fas fa-lg fa-fw fa-caret-right"
              :class="{ 'fa-rotate-90': showOptions }"
            ></span>
            {{ $t('common.options') }}
          </h5>
          <collapse :active="showOptions" class="form-row px-2" tag="div">
            <div v-for="option in chemicalProperties.options" :key="option.label" class="col-sm-6">
              <div class="custom-control custom-checkbox mb-2">
                <input
                  :id="option.label"
                  v-model="chemicalProperties.selected"
                  class="custom-control-input"
                  type="checkbox"
                  :value="option.key"
                />
                <label class="custom-control-label" :for="option.label">{{ option.label }}</label>
              </div>
            </div>
          </collapse>
        </div>
      </form>
      <hr />
      <h5>{{ $t('chemicals.data.results') }}</h5>
      <div v-if="!!Object.keys(results.list).length">
        <div
          v-for="(result, key) in results.list"
          v-show="!['brand_id', 'catalog_id'].includes(key)"
          :key="key"
          class="input-group mb-3"
        >
          <div class="input-group-prepend">
            <div class="input-group-text">
              <div class="custom-control custom-checkbox">
                <input
                  :id="key"
                  v-model="results.selected"
                  class="custom-control-input"
                  type="checkbox"
                  :value="key"
                />
                <label class="custom-control-label" :for="key">{{ result.label }}</label>
              </div>
            </div>
          </div>
          <input
            :aria-label="result.label"
            class="form-control"
            type="text"
            :value="result.value"
          />
        </div>
      </div>
    </div>
    <div class="modal-footer">
      <button class="btn btn-outline-secondary" type="button" @click.stop="close()">
        <span class="fas fa-fw fa-times" :title="$t('common.cancel').toString()"></span>
        {{ $t('common.cancel') }}
      </button>
      <button
        class="btn btn-primary"
        :disabled="!results.selected.length"
        type="button"
        @click.stop="confirm()"
      >
        <span class="fas fa-fw fa-paste" :title="$t('common.insert').toString()"></span>
        {{ $t('common.insert') }}
      </button>
    </div>
  </modal>
</template>

<script lang="ts">
import type { PropType } from 'vue';
import { defineComponent } from 'vue';

import type {
  ChemicalPropertyOption,
  ChemicalPropertyResults,
  ChemicalSource,
  Dictionary,
} from '@/types';
import { Multiselect } from '@/components/forms';
import { cactusService, saService } from '@/services';

import ModalMixin from './ModalMixin';

export default defineComponent({
  name: 'ChemicalData',

  components: { Multiselect },

  mixins: [ModalMixin],

  props: {
    productId: {
      type: String,
    },
    cas: {
      type: String,
    },
    brands: {
      type: Array as PropType<Dictionary[]>,
      default: () => [],
    },
  },

  data() {
    const chemicalPropertyOptions: ChemicalPropertyOption[] = [
      {
        key: 'brand_id',
        label: this.$t('chemicals.brand._').toString(),
        saCall: (details) => {
          const brandKey = details.brand.key.toLocaleLowerCase();
          const brand = this.brands.find((brand) => brand.parse_callback === brandKey);
          return brand ? brand.id : null;
        },
      },
      {
        key: 'catalog_id',
        label: this.$t('chemicals.brand.id').toString(),
        saCall: 'productKey',
      },
      {
        key: 'name',
        label: this.$t('chemicals.name').toString(),
        saCall: 'name',
      },
      {
        key: 'synonym',
        label: this.$t('chemicals.synonym').toString(),
        saCall: (details) => details.synonyms.join(', '),
      },
      {
        key: 'iupac',
        label: this.$t('chemicals.iupac').toString(),
        cactusCall: 'iupac',
      },
      {
        key: 'cas',
        label: this.$t('chemicals.cas').toString(),
        cactusCall: 'cas',
        saCall: 'casNumber',
      },
      {
        key: 'mw',
        label: this.$t('chemicals.mw').toString(),
        cactusCall: 'mw',
        saCall: 'molecularWeight',
      },
      {
        key: 'formula',
        label: this.$t('chemicals.formula').toString(),
        cactusCall: 'formula',
        saCall: (details) => details.empiricalFormula.replaceAll(/<\/?sub>/gi, ''),
      },
      {
        key: 'pubchem',
        label: this.$t('chemicals.pubchem._').toString(),
      },
      {
        key: 'description',
        label: this.$t('common.description').toString(),
        saCall: 'description',
      },
      {
        key: 'sdf',
        label: this.$t('chemicals.structure.sdf').toString(),
        cactusCall: 'sdf',
      },
      {
        key: 'smiles',
        label: this.$t('chemicals.structure.smiles').toString(),
        cactusCall: 'smiles',
      },
      {
        key: 'inchikey',
        label: this.$t('chemicals.structure.inchikey').toString(),
        cactusCall: 'inchikey',
      },
      {
        key: 'inchi',
        label: this.$t('chemicals.structure.inchi').toString(),
        cactusCall: 'inchi',
      },
      {
        key: 'symbol',
        label: this.$t('msds.symbol').toString(),
        saCall: (details) =>
          details.compliance.find(({ key }) => key === 'pictograms')?.value.split('+') ?? [],
      },
      {
        key: 'signal_word',
        label: this.$t('msds.signal_word').toString(),
        saCall: (details) =>
          details.compliance.find(({ key }) => key === 'signalword')?.value ?? null,
      },
      {
        key: 'h',
        label: this.$t('msds.h_abbr').toString(),
        saCall: (details) =>
          details.compliance
            .find(({ key }) => key === 'hcodes')
            ?.value.split('-')
            .map((item) => item.replaceAll(' + ', '+').trim()) ?? [],
      },
      {
        key: 'p',
        label: this.$t('msds.p_abbr').toString(),
        saCall: (details) =>
          details.compliance
            .find(({ key }) => key === 'pcodes')
            ?.value.split('-')
            .map((item) => item.replaceAll(' + ', '+').trim()) ?? [],
      },
    ];

    return {
      search: null as string | null,
      showOptions: false,
      sources: {
        list: [
          {
            id: 'sigma',
            name: this.$t('chemicals.data.sigma._').toString(),
            hint: this.$t('chemicals.data.sigma.hint').toString(),
          },
          {
            id: 'cactus',
            name: this.$t('chemicals.data.cactus._').toString(),
            hint: this.$t('chemicals.data.cactus.hint').toString(),
          },
        ] as ChemicalSource[],
        selected: [] as string[],
      },
      chemicalProperties: {
        options: chemicalPropertyOptions,
        selected: chemicalPropertyOptions.map((item) => item.key),
      },
      results: {
        list: {} as ChemicalPropertyResults,
        selected: [] as string[],
      },
    };
  },

  computed: {
    hints() {
      return this.sources.list.filter((item) => this.sources.selected.includes(item.id));
    },
  },

  methods: {
    beforeOpen() {
      const { cas, productId } = this;
      if (productId) {
        this.search = productId;
        this.sources.selected = ['sigma', 'cactus'];
      } else {
        this.search = cas ?? null;
        this.sources.selected = ['cactus'];
      }
    },

    async cactus(search: string) {
      for (const option of this.chemicalProperties.options) {
        const { key, cactusCall, label } = option;
        if (!cactusCall || !this.chemicalProperties.selected.includes(key)) continue;

        const value = await cactusService[cactusCall](search);
        if (value) {
          this.results.list = { ...this.results.list, [key]: { label, value } };
          if (!this.results.selected.includes(key)) this.results.selected.push(key);
        } else {
          this.$toasted.info(
            this.$t('chemicals.data.cactus.not-found', { label, search }).toString()
          );
        }
      }
    },

    async vendor(productKey: string) {
      const results = await saService.findProductDetails(productKey);
      if (!results.length) {
        this.$toasted.info(
          this.$t('chemicals.data.vendor.not-found', { search: productKey }).toString()
        );
        return;
      }

      const result = results[0];

      for (const option of this.chemicalProperties.options) {
        const { key, saCall, label } = option;
        if (!saCall || !this.chemicalProperties.selected.includes(key)) continue;

        const value = typeof saCall === 'string' ? result[saCall] : saCall(result);
        if (!value) return;

        this.results.list = { ...this.results.list, [key]: { label, value } };
        if (!this.results.selected.includes(key)) this.results.selected.push(key);
      }
    },

    async onSearch() {
      const { search } = this;
      if (!search) {
        this.$toasted.info('Nothing entered');
        return;
      }

      // Reset results
      this.showOptions = false;
      this.results.list = {};
      this.results.selected = [];

      if (this.sources.selected.includes('sigma')) {
        await this.vendor(search);
      }

      if (this.sources.selected.includes('cactus'))
        await this.cactus(this.results.list.cas?.value?.toString() ?? search);
    },

    confirm() {
      if (!this.results.selected.length) {
        this.$toasted.info('No results selected.');
        return;
      }

      const toImport = Object.entries(this.results.list).reduce<
        Record<string, string | string[] | null>
      >((acc, [key, item]) => {
        if (this.results.selected.includes(key)) acc[key] = item.value;
        return acc;
      }, {});

      this.$emit('confirm', toImport);
      this.close();
    },
  },
});
</script>

<style>
.cursor {
  cursor: pointer;
}
</style>
