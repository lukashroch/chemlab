<template>
  <div v-if="refsLoaded" class="card-header">
    <div class="row mb-3">
      <div class="col-12 col-sm mb-2 mb-sm-0 d-inline-flex">
        <button class="btn btn-warning me-2" type="button" @click="resetFilter">
          <span class="fas fa-times" :title="$t('common.search.clear')"></span>
        </button>
        <label class="sr-only">{{ $t('common.search._') }}</label>
        <typeahead v-model="filter.text" @submit="setFilter"></typeahead>
      </div>
      <div
        v-for="(select, key) in filterRefs"
        :key="key"
        :class="key === 'store' ? 'col-sm-4' : 'col-sm-2'"
      >
        <multiselect
          v-model="filter[key]"
          :options="select"
          :placeholder="$t(`common.filter.${key}`)"
        >
        </multiselect>
      </div>
      <div class="col-sm-auto">
        <div>
          <button
            v-if="module === 'chemicals'"
            id="searchAdvanced"
            class="btn btn-outline-secondary me-1"
            :title="$t('common.search.advanced')"
            @click="advanced = !advanced"
          >
            <span class="fas fa-ellipsis-v"></span>
          </button>
          <button
            class="btn btn-primary"
            :title="$t('common.search._')"
            type="button"
            @click="setFilter"
          >
            <span class="fas fa-search" :title="$t('common.search._')"></span>
            {{ $t('common.search._') }}
          </button>
        </div>
      </div>
    </div>
    <Vue3SlideUpDown v-if="module === 'chemicals'" :model-value="advanced" tag="div">
      <div class="row mb-3">
        <div class="col-md-5 col-lg-4">
          <div class="form-check ms-2 mb-2">
            <input
              id="recent"
              v-model="filter.recent"
              class="form-check-input"
              name="recent"
              type="checkbox"
            />
            <label class="form-check-label" for="recent">
              {{ $t('chemicals.search.recent') }}
            </label>
          </div>
        </div>
      </div>
      <div class="row mb-3">
        <label class="col-form-label sr-only">{{ $t('chemicals.chemspider._') }}</label>
        <div class="col-md-5 col-lg-4">
          <input
            id="chemspider"
            v-model="filter.chemspider"
            class="form-control"
            name="chemspider"
            :placeholder="$t('chemicals.chemspider._')"
            type="text"
            @keyup.enter="setFilter"
          />
        </div>
        <label class="col-form-label sr-only">{{ $t('chemicals.pubchem._') }}</label>
        <div class="col-md-5 col-lg-4">
          <input
            id="pubchem"
            v-model="filter.pubchem"
            class="form-control"
            name="pubchem"
            :placeholder="$t('chemicals.pubchem._')"
            type="text"
            @keyup.enter="setFilter"
          />
        </div>
      </div>
      <div class="row mb-3">
        <label class="col-form-label sr-only">{{ $t('chemicals.formula') }}</label>
        <div class="col-md-5 col-lg-4">
          <input
            id="formula"
            v-model="filter.formula"
            class="form-control"
            name="formula"
            :placeholder="$t('chemicals.formula')"
            type="text"
            @keyup.enter="setFilter"
          />
        </div>
        <label class="col-form-label sr-only">{{ $t('chemicals.structure.inchikey') }}</label>
        <div class="col-md-5 col-lg-4">
          <div class="input-group">
            <input
              id="inchikey"
              v-model="filter.inchikey"
              class="form-control"
              name="inchikey"
              :placeholder="$t('chemicals.structure.inchikey')"
              type="text"
            />
            <ketcher @inchikey="inchikey"></ketcher>
          </div>
        </div>
      </div>
    </Vue3SlideUpDown>
    <div class="row">
      <div v-show="items.length" class="col">
        {{ $t('common.search.filter') }}:
        <span v-for="item in items" :key="item" class="badge bg-primary me-1 p-2"> {{ item }}</span>
      </div>
      <div class="col-sm-auto ms-auto">
        {{ $t('common.records.count') }}:
        <span>{{ count }}</span>
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import isEmpty from 'lodash/isEmpty';
import { mapState } from 'pinia';
import { defineComponent } from 'vue';
import { Vue3SlideUpDown } from 'vue3-slide-up-down';

import type { Filter, FilterRefs } from '@/stores';
import { Multiselect } from '@/components/forms';
import { Ketcher } from '@/components/modals';
import { useResource } from '@/stores';

import Typeahead from './Typeahead.vue';

export default defineComponent({
  name: 'DataTableFilter',

  components: { Ketcher, Multiselect, Typeahead, Vue3SlideUpDown },

  props: {
    count: {
      type: Number,
      default: 0,
    },
  },

  emits: ['filter-set', 'filter-reset'],

  data() {
    const origFilter = (): Filter =>
      this.$route.meta?.module === 'chemicals'
        ? {
            text: '',
            recent: false,
            pubchem: null,
            chemspider: null,
            formula: null,
            inchikey: null,
            store: [],
          }
        : {
            text: '',
            recent: false,
          };

    return {
      advanced: false,
      items: [] as string[],
      origFilter,
      filter: origFilter(),
    };
  },

  computed: {
    ...mapState(useResource, {
      refsLoaded: 'refsLoaded',
      refs: 'refs',
      activeFilter: 'getFilter',
    }),
    filterRefs(): FilterRefs {
      return this.refs.filter || {};
    },
  },

  watch: {
    activeFilter: {
      handler(val) {
        this.filter = { ...(isEmpty(val) ? this.origFilter() : val) };
        this.refreshItems();
      },
      immediate: true,
    },
    filterRefs(val) {
      if (Object.keys(val).length) this.refreshItems();
    },
  },

  methods: {
    setFilter() {
      this.refreshItems();
      this.$emit('filter-set', this.filter);
    },

    resetFilter() {
      this.$emit('filter-reset');
    },

    refreshItems() {
      this.items = [];
      Object.keys(this.filter).forEach((key) => {
        if (Array.isArray(this.filter[key]) && this.filterRefs[key]) {
          const stores = this.filterRefs[key].reduce<string[]>((acc, item) => {
            if (this.filter[key].includes(item.id)) acc.push(item.name);
            return acc;
          }, []);
          this.items.push(...stores);
        } else if (!['recent'].includes(key)) this.items.push(this.filter[key]);
      });
      this.items = this.items.filter(Boolean);
    },

    inchikey(inchikey: string) {
      this.filter.inchikey = inchikey;
    },
  },
});
</script>
