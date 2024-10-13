<template>
  <layout v-if="entryLoaded" v-bind="{ id, entry }">
    <template #actions>
      <chemical-data
        ref="chemicalData"
        :brands="refs.brands"
        :cas="form.cas"
        :product-id="form.catalog_id"
        @confirm="loadChemicalData"
      ></chemical-data>
    </template>
    <div class="tab-pane active">
      <form @keydown="clearError" @submit.prevent="submit">
        <div class="card-body">
          <div class="row mb-3">
            <label class="col-md-2 col-form-label" for="name">{{ $t('common.title') }}</label>
            <div class="col-md-10">
              <input
                id="name"
                v-model="form.name"
                class="form-control"
                name="name"
                :placeholder="$t('common.title')"
                type="text"
              />
              <error :msg="form.errors.get('name')"></error>
            </div>
          </div>
          <div class="row mb-3">
            <label class="col-md-2 col-form-label" for="iupac">{{ $t('chemicals.iupac') }}</label>
            <div class="col-md-10">
              <input
                id="iupac"
                v-model="form.iupac"
                class="form-control"
                name="iupac"
                :placeholder="$t('chemicals.iupac')"
                type="text"
              />
              <error :msg="form.errors.get('iupac')"></error>
            </div>
          </div>
          <div class="row mb-3">
            <label class="col-md-2 col-form-label" for="synonym">
              {{ $t('chemicals.synonym') }}
            </label>
            <div class="col-md-10">
              <input
                id="synonym"
                v-model="form.synonym"
                class="form-control"
                name="synonym"
                :placeholder="$t('chemicals.synonym')"
                type="text"
              />
              <error :msg="form.errors.get('synonym')"></error>
            </div>
          </div>
          <div class="row mb-3">
            <label class="col-md-2 col-form-label" for="symbol">{{ $t('categories.index') }}</label>
            <div class="col-md-10">
              <multiselect
                id="categories"
                v-model="form.categories"
                :options="refs.categories"
                @input="form.errors.clear('categories')"
              ></multiselect>
              <error :msg="form.errors.get('categories')"></error>
            </div>
          </div>
          <div class="row mb-3">
            <label class="col-md-2 col-form-label" for="catalog_id">
              {{ $t('chemicals.brand.id') }}
            </label>
            <div class="col-md-4">
              <input
                id="catalog_id"
                v-model="form.catalog_id"
                class="form-control"
                name="catalog_id"
                :placeholder="$t('chemicals.brand.id')"
                type="text"
                @input="form.errors.clear(['brand_id', 'catalog_id'])"
              />
              <error :msg="form.errors.get('catalog_id')"></error>
            </div>
            <label class="col-md-2 col-form-label" for="brand_id">
              {{ $t('chemicals.brand._') }}
            </label>
            <div class="col-md-4">
              <select
                id="brand_id"
                v-model="form.brand_id"
                class="form-select"
                name="brand_id"
                @change="form.errors.clear(['brand_id', 'catalog_id'])"
              >
                <option v-for="brands in refs.brands" :key="brands.id" :value="brands.id">
                  {{ brands.name }}
                </option>
              </select>
              <error :msg="form.errors.get('brand_id')"></error>
            </div>
          </div>
          <div class="row mb-3">
            <label class="col-md-2 col-form-label" for="cas">{{ $t('chemicals.cas') }}</label>
            <div class="col-md-4">
              <input
                id="cas"
                v-model="form.cas"
                class="form-control"
                name="cas"
                :placeholder="$t('chemicals.cas')"
                type="text"
              />
              <error :msg="form.errors.get('cas')"></error>
            </div>
            <label class="col-md-2 col-form-label" for="pubchem">
              {{ $t('chemicals.pubchem._') }}
            </label>
            <div class="col-md-4">
              <input
                id="pubchem"
                v-model="form.pubchem"
                class="form-control"
                name="pubchem"
                :placeholder="$t('chemicals.pubchem._')"
                type="text"
              />
              <error :msg="form.errors.get('pubchem._')"></error>
            </div>
          </div>
          <div class="row mb-3">
            <label class="col-md-2 col-form-label" for="mw">{{ $t('chemicals.mw') }}</label>
            <div class="col-md-4">
              <input
                id="mw"
                v-model="form.mw"
                class="form-control"
                name="mw"
                :placeholder="$t('chemicals.mw')"
                type="text"
              />
              <error :msg="form.errors.get('mw')"></error>
            </div>
            <label class="col-md-2 col-form-label" for="formula">{{
              $t('chemicals.formula')
            }}</label>
            <div class="col-md-4">
              <input
                id="formula"
                v-model="form.formula"
                class="form-control"
                name="formula"
                :placeholder="$t('chemicals.formula')"
                type="text"
              />
              <error :msg="form.errors.get('formula')"></error>
            </div>
          </div>
          <div class="row mb-3">
            <label class="col-md-2 col-form-label" for="chemspider">{{
              $t('chemicals.chemspider._')
            }}</label>
            <div class="col-md-4">
              <input
                id="chemspider"
                v-model="form.chemspider"
                class="form-control"
                name="chemspider"
                :placeholder="$t('chemicals.chemspider._')"
                type="text"
              />
              <error :msg="form.errors.get('chemspider')"></error>
            </div>
          </div>
          <div class="row mb-3">
            <label class="col-form-label col-md-2" for="description">
              {{ $t('common.description') }}
            </label>
            <div class="col-md-10">
              <textarea
                id="description"
                v-model="form.description"
                class="form-control"
                name="description"
                :placeholder="$t('common.description')"
                rows="4"
              ></textarea>
              <error :msg="form.errors.get('description')"></error>
            </div>
          </div>
          <!-- SDS Info -->
          <div class="row mb-3">
            <label class="col-md-2 col-form-label" for="symbol">{{ $t('msds.symbol') }}</label>
            <div class="col-md-4">
              <multiselect
                id="symbols"
                v-model="form.symbol"
                :options="symbols"
                @input="form.errors.clear('symbol')"
              ></multiselect>
              <error :msg="form.errors.get('symbol')"></error>
            </div>
            <label class="col-md-2 col-form-label" for="signal_word"
              >{{ $t('msds.signal_word') }}
            </label>
            <div class="col-md-4">
              <input
                id="signal_word"
                v-model="form.signal_word"
                class="form-control"
                name="signal_word"
                :placeholder="$t('msds.signal_word')"
                type="text"
              />
              <error :msg="form.errors.get('signal_word')"></error>
            </div>
          </div>

          <div class="row mb-3">
            <label class="col-md-2 col-form-label" for="h">{{ $t('msds.h_abbr') }}</label>
            <div class="col-md-10">
              <multiselect
                id="h"
                v-model="form.h"
                :options="hOptions"
                @input="form.errors.clear('h')"
              ></multiselect>
              <error :msg="form.errors.get('h')"></error>
            </div>
          </div>
          <div class="row mb-3">
            <label class="col-md-2 col-form-label" for="p">{{ $t('msds.p_abbr') }}</label>
            <div class="col-md-10">
              <multiselect
                id="p"
                v-model="form.p"
                :options="pOptions"
                @input="form.errors.clear('p')"
              ></multiselect>
              <error :msg="form.errors.get('p')"></error>
            </div>
          </div>
        </div>
        <submit-footer :disabled="form.hasErrors()"></submit-footer>
      </form>
    </div>
    <template #addons>
      <items v-if="isEdit" :chemical-id="id"></items>
    </template>
  </layout>
</template>

<script lang="ts">
import { watchDebounced } from '@vueuse/core';
import { computed, defineComponent, reactive } from 'vue';
import { useI18n } from 'vue-i18n';

import type { ChemicalForm, Dictionary, SDSOption } from '@/types';
import { formMixin } from '@/components/entry';
import { Multiselect } from '@/components/forms';
import { ChemicalData } from '@/components/modals';
import messages from '@/i18n/messages.json';
import { useHttp } from '@/services';
import { createForm } from '@/util';

import Items from './Items.vue';

export default defineComponent({
  name: 'ChemicalForm',

  components: { Items, Multiselect, ChemicalData },

  mixins: [formMixin],

  setup() {
    const i18n = useI18n();
    const http = useHttp();

    const form = reactive(
      createForm<ChemicalForm>({
        id: null,
        name: null,
        iupac: null,
        synonym: null,
        brand_id: null,
        categories: [],
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
          sdf: null,
          smiles: null,
        },
        signal_word: null,
        h: [],
        p: [],
        r: [],
        s: [],
        symbol: [],
      })
    );

    const getOptions = (path: string) => {
      // @ts-expect-error - not typed
      return messages[i18n.locale.value].msds[path];
    };

    function formatOptions(items: Dictionary<string>): SDSOption[] {
      return Object.entries(items).reduce<SDSOption[]>((acc, [id, name]) => {
        acc.push({ id, name });
        return acc;
      }, []);
    }

    const symbols = computed(() => formatOptions(getOptions('symbols')));
    const hOptions = computed(() => formatOptions(getOptions('h')));
    const pOptions = computed(() => formatOptions(getOptions('p')));

    async function checkBrand() {
      const { id, brand_id, catalog_id } = form;
      try {
        await http.post('chemicals/check-brand', { id, brand_id, catalog_id });
      } catch (err) {
        if (err.response?.status === 422) form.errors.record(err.response?.data?.errors);
      }
    }

    async function loadChemicalData(results: Dictionary) {
      const { inchi, inchikey, sdf, smiles, ...rest } = results;
      const data = { ...rest, structure: { inchi, inchikey, sdf, smiles } };
      form.assign(data);
    }

    watchDebounced(
      () => [form.brand_id, form.catalog_id],
      async () => {
        await checkBrand();
      },
      { debounce: 500, maxWait: 2000 }
    );

    return {
      form,
      symbols,
      hOptions,
      pOptions,
      loadChemicalData,
    };
  },

  methods: {},
});
</script>

<style lang="scss" scoped></style>
