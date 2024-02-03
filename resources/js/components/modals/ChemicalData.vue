<template>
  <button class="btn btn-primary me-1" @click="open">
    <span class="fas fa-search"></span>
    {{ $t('chemicals.data._') }}
  </button>
  <vue-final-modal
    v-model="dialog"
    class="d-flex justify-content-center align-items-center"
    content-class="bg-white rounded chemical-data-dialog overflow-y-auto"
  >
    <div class="d-flex justify-content-between align-items-center px-4 py-2 border border-bottom">
      <h5 class="mb-0">{{ $t('chemicals.data._') }}</h5>
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
      <form @submit.prevent="onSearch">
        <div class="row mb-3">
          <label class="col-form-label col-3" for="source">{{ $t('chemicals.data.source') }}</label>
          <div class="col">
            <multiselect
              v-model="sources.selected"
              :options="sources.list"
              :placeholder="$t('chemicals.data.source')"
            >
            </multiselect>
            <small v-for="source in hints" :key="source.id" class="form-text mb-0">
              <span class="fas fa-info"></span> {{ source.hint }}
            </small>
          </div>
        </div>
        <div class="row mb-3">
          <label class="col-form-label col-3" for="search">{{ $t('chemicals.data.id') }}</label>
          <div class="col">
            <div class="input-group">
              <input
                id="search"
                v-model="search"
                class="form-control"
                name="search"
                :placeholder="$t('chemicals.data.id')"
                type="text"
              />
              <button class="btn btn-primary" :disabled="!search" type="submit">
                <span class="fas fa-search"></span> {{ $t('common.search._') }}
              </button>
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
          <Vue3SlideUpDown class="row px-2" :model-value="showOptions" tag="div">
            <div v-for="option in chemicalProperties.options" :key="option.label" class="col-sm-6">
              <div class="form-check mb-2">
                <input
                  :id="option.label"
                  v-model="chemicalProperties.selected"
                  class="form-check-input"
                  type="checkbox"
                  :value="option.key"
                />
                <label class="form-check-label" :for="option.label">{{ option.label }}</label>
              </div>
            </div>
          </Vue3SlideUpDown>
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
          <div class="input-group-text">
            <div class="form-check">
              <input
                :id="key"
                v-model="results.selected"
                class="form-check-input"
                type="checkbox"
                :value="key"
              />
              <label class="form-check-label" :for="key">{{ result.label }}</label>
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
      <div>
        <button class="btn btn-outline-secondary me-1" type="button" @click.stop="close">
          <span class="fas fa-times" :title="$t('common.cancel')"></span>
          {{ $t('common.cancel') }}
        </button>
        <button
          class="btn btn-primary"
          :disabled="!results.selected.length"
          type="button"
          @click.stop="confirm"
        >
          <span class="fas fa-paste" :title="$t('common.insert')"></span>
          {{ $t('common.insert') }}
        </button>
      </div>
    </div>
  </vue-final-modal>
</template>

<script lang="ts">
import type { PropType } from 'vue';
import { computed, defineComponent, reactive, ref, watch } from 'vue';
import { VueFinalModal } from 'vue-final-modal';
import { useI18n } from 'vue-i18n';
import { Vue3SlideUpDown } from 'vue3-slide-up-down';

import type {
  ChemicalPropertyOption,
  ChemicalPropertyResults,
  ChemicalSource,
  Dictionary,
} from '@/types';
import { Multiselect } from '@/components/forms';
import { cactusService, saService } from '@/services';
import { useMessages } from '@/stores';

type Sources = {
  list: ChemicalSource[];
  selected: string[];
};

type Results = {
  list: ChemicalPropertyResults;
  selected: string[];
};

export default defineComponent({
  name: 'ChemicalData',

  components: { Multiselect, VueFinalModal, Vue3SlideUpDown },

  props: {
    productId: {
      type: String as PropType<string | null>,
    },
    cas: {
      type: String as PropType<string | null>,
    },
    brands: {
      type: Array as PropType<Dictionary[]>,
      default: () => [],
    },
  },

  emits: ['confirm'],

  setup(props) {
    const { t } = useI18n();

    const chemicalPropertyOptions: ChemicalPropertyOption[] = [
      {
        key: 'brand_id',
        label: t('chemicals.brand._'),
        saCall: (details) => {
          const brandKey = details.brand.key.toLocaleLowerCase();
          const brand = props.brands.find((brand) => brand.parse_callback === brandKey);
          return brand ? brand.id : null;
        },
      },
      {
        key: 'catalog_id',
        label: t('chemicals.brand.id'),
        saCall: 'productKey',
      },
      {
        key: 'name',
        label: t('chemicals.name'),
        saCall: 'name',
      },
      {
        key: 'synonym',
        label: t('chemicals.synonym'),
        saCall: (details) => details.synonyms.join(', '),
      },
      {
        key: 'iupac',
        label: t('chemicals.iupac'),
        cactusCall: 'iupac',
      },
      {
        key: 'cas',
        label: t('chemicals.cas'),
        cactusCall: 'cas',
        saCall: 'casNumber',
      },
      {
        key: 'mw',
        label: t('chemicals.mw'),
        cactusCall: 'mw',
        saCall: 'molecularWeight',
      },
      {
        key: 'formula',
        label: t('chemicals.formula'),
        cactusCall: 'formula',
        saCall: (details) => details.empiricalFormula.replaceAll(/<\/?sub>/gi, ''),
      },
      {
        key: 'pubchem',
        label: t('chemicals.pubchem._'),
      },
      {
        key: 'description',
        label: t('common.description'),
        saCall: 'description',
      },
      {
        key: 'sdf',
        label: t('chemicals.structure.sdf'),
        cactusCall: 'sdf',
      },
      {
        key: 'smiles',
        label: t('chemicals.structure.smiles'),
        cactusCall: 'smiles',
      },
      {
        key: 'inchikey',
        label: t('chemicals.structure.inchikey'),
        cactusCall: 'inchikey',
      },
      {
        key: 'inchi',
        label: t('chemicals.structure.inchi'),
        cactusCall: 'inchi',
      },
      {
        key: 'symbol',
        label: t('msds.symbol'),
        saCall: (details) =>
          details.compliance.find(({ key }) => key === 'pictograms')?.value.split('+') ?? [],
      },
      {
        key: 'signal_word',
        label: t('msds.signal_word'),
        saCall: (details) =>
          details.compliance.find(({ key }) => key === 'signalword')?.value ?? null,
      },
      {
        key: 'h',
        label: t('msds.h_abbr'),
        saCall: (details) =>
          details.compliance
            .find(({ key }) => key === 'hcodes')
            ?.value.split('-')
            .map((item) => item.replaceAll(' + ', '+').trim()) ?? [],
      },
      {
        key: 'p',
        label: t('msds.p_abbr'),
        saCall: (details) =>
          details.compliance
            .find(({ key }) => key === 'pcodes')
            ?.value.split('-')
            .map((item) => item.replaceAll(' + ', '+').trim()) ?? [],
      },
    ];

    const chemicalProperties = {
      options: chemicalPropertyOptions,
      selected: chemicalPropertyOptions.map((item) => item.key),
    };

    const sources: Sources = {
      list: [
        {
          id: 'sigma',
          name: t('chemicals.data.sigma._'),
          hint: t('chemicals.data.sigma.hint'),
        },
        {
          id: 'cactus',
          name: t('chemicals.data.cactus._'),
          hint: t('chemicals.data.cactus.hint'),
        },
      ],
      selected: [],
    };

    const results = reactive<Results>({
      list: {},
      selected: [],
    });

    const hints = computed(() => sources.list.filter((item) => sources.selected.includes(item.id)));

    const dialog = ref(false);
    const search = ref<string | null>(null);
    const showOptions = ref(false);

    function close() {
      dialog.value = false;
    }

    function open() {
      dialog.value = true;
    }

    watch(dialog, (value) => {
      if (!value) return;

      if (props.productId) {
        search.value = props.productId;
        sources.selected = ['sigma', 'cactus'];
      } else {
        search.value = props.cas ?? null;
        sources.selected = ['cactus'];
      }
    });

    return {
      dialog,
      close,
      open,
      chemicalProperties,
      hints,
      results,
      search,
      showOptions,
      sources,
    };
  },

  methods: {
    async cactus(search: string) {
      for (const option of this.chemicalProperties.options) {
        const { key, cactusCall, label } = option;
        if (!cactusCall || !this.chemicalProperties.selected.includes(key)) continue;

        const value = await cactusService[cactusCall](search);
        if (value) {
          this.results.list = { ...this.results.list, [key]: { label, value } };
          if (!this.results.selected.includes(key)) this.results.selected.push(key);
        } else {
          useMessages().info(this.$t('chemicals.data.cactus.not-found', { label, search }));
        }
      }
    },

    async vendor(productKey: string) {
      const productDetails = await saService.findProductDetails(productKey);
      if (!productDetails) {
        useMessages().info(this.$t('chemicals.data.vendor.not-found', { search: productKey }));
        return;
      }

      for (const option of this.chemicalProperties.options) {
        const { key, saCall, label } = option;
        if (!saCall || !this.chemicalProperties.selected.includes(key)) continue;

        const value = typeof saCall === 'string' ? productDetails[saCall] : saCall(productDetails);
        if (!value) return;

        this.results.list = { ...this.results.list, [key]: { label, value } };
        if (!this.results.selected.includes(key)) this.results.selected.push(key);
      }
    },

    async onSearch() {
      const { search } = this;
      if (!search) {
        useMessages().info('Nothing entered');
        return;
      }

      // Reset results
      this.showOptions = false;
      this.results.list = {};
      this.results.selected = [];

      if (this.sources.selected.includes('sigma')) await this.vendor(search);

      if (this.sources.selected.includes('cactus'))
        await this.cactus(this.results.list.cas?.value?.toString() ?? search);
    },

    confirm() {
      if (!this.results.selected.length) {
        useMessages().info('No results selected.');
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

.chemical-data-dialog {
  max-width: 700px;
  max-height: 80vh;
}
</style>
