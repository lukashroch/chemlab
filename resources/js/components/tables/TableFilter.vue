<template>
  <div v-if="refsLoaded" class="card-header">
    <div class="form-group form-row">
      <div class="col-12 col-sm mb-2 mb-sm-0 d-inline-flex">
        <button class="btn btn-warning mr-2" type="button" @click="resetFilter">
          <span class="fas fa-times" :title="$t('common.search.clear').toString()"></span>
        </button>
        <label class="sr-only">{{ $t('common.search._') }}</label>
        <typeahead v-model="filter.text" @submit="doFilter"></typeahead>
      </div>
      <template v-for="(select, key) in filterRefs">
        <div :key="key" :class="key === 'store' ? 'col-sm-4' : 'col-sm-2'">
          <multiselect
            v-model="filter[key]"
            :options="select"
            :placeholder="$t(`common.filter.${key}`).toString()"
          ></multiselect>
        </div>
      </template>
      <div class="col-sm-auto">
        <div>
          <button
            v-if="module === 'chemicals'"
            id="searchAdvanced"
            class="btn btn-outline-secondary"
            :title="$t('common.search.advanced').toString()"
            @click="advanced = !advanced"
          >
            <span class="fas fa-ellipsis-v"></span>
          </button>
          <button
            class="btn btn-primary"
            :title="$t('common.search._').toString()"
            type="button"
            @click="doFilter"
          >
            <span class="fas fa-search" :title="$t('common.search._').toString()"></span>
            {{ $t('common.search._') }}
          </button>
        </div>
      </div>
    </div>
    <collapse v-if="module === 'chemicals'" :active="advanced" class="" tag="div">
      <div class="form-group form-row">
        <div class="col-md-5 col-lg-4">
          <div class="custom-control custom-checkbox ml-2 mb-2">
            <input
              id="recent"
              v-model="filter.recent"
              class="custom-control-input"
              name="recent"
              type="checkbox"
            />
            <label class="custom-control-label" for="recent">
              {{ $t('chemicals.search.recent') }}
            </label>
          </div>
        </div>
      </div>
      <div class="form-group form-row">
        <label class="col-form-label sr-only">{{ $t('chemicals.chemspider._') }}</label>
        <div class="col-md-5 col-lg-4">
          <input
            id="chemspider"
            v-model="filter.chemspider"
            class="form-control"
            name="chemspider"
            :placeholder="$t('chemicals.chemspider._').toString()"
            type="text"
            @keyup.enter="doFilter"
          />
        </div>
        <label class="col-form-label sr-only">{{ $t('chemicals.pubchem._') }}</label>
        <div class="col-md-5 col-lg-4">
          <input
            id="pubchem"
            v-model="filter.pubchem"
            class="form-control"
            name="pubchem"
            :placeholder="$t('chemicals.pubchem._').toString()"
            type="text"
            @keyup.enter="doFilter"
          />
        </div>
      </div>
      <div class="form-group form-row">
        <label class="col-form-label sr-only">{{ $t('chemicals.formula') }}</label>
        <div class="col-md-5 col-lg-4">
          <input
            id="formula"
            v-model="filter.formula"
            class="form-control"
            name="formula"
            :placeholder="$t('chemicals.formula').toString()"
            type="text"
            @keyup.enter="doFilter"
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
              :placeholder="$t('chemicals.structure.inchikey').toString()"
              type="text"
            />
            <div class="input-group-append">
              <button class="btn btn-secondary" @click="$modal.show('ketcher')">
                <span
                  class="fas fa-fw fa-draw-polygon"
                  :title="$t('chemicals.structure._').toString()"
                ></span>
              </button>
            </div>
          </div>
        </div>
        <ketcher name="ketcher" @inchikey="onInchikey"></ketcher>
      </div>
    </collapse>
    <div class="row">
      <div v-show="items.length" class="col small">
        {{ $t('common.search.filter') }}:
        <span v-for="item in items" :key="item" class="badge badge-primary mr-1">{{ item }}</span>
      </div>
      <div class="col-sm-auto small ml-auto">
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

import type { Filter, FilterRefs } from '@/stores';
import { Multiselect } from '@/components/forms';
import { Ketcher } from '@/components/modals';
import { useResource } from '@/stores';

import Typeahead from './Typeahead.vue';

export default defineComponent({
  name: 'VuetableFilter',

  components: { Ketcher, Multiselect, Typeahead },

  props: {
    count: {
      type: Number,
      default: 0,
    },
  },

  data() {
    let origFilter: Filter = {
      text: '',
      recent: false,
    };

    if (this.$route.meta?.module === 'chemicals') {
      origFilter = {
        ...origFilter,
        ...{
          pubchem: null,
          chemspider: null,
          formula: null,
          inchikey: null,
        },
      };
    }

    return {
      advanced: false,
      items: [] as string[],
      origFilter,
      filter: {} as Filter,
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
        this.filter = { ...(isEmpty(val) ? this.origFilter : val) };
        this.loadApplied();
      },
      immediate: true,
    },
    filterRefs(val) {
      if (Object.keys(val).length) this.loadApplied();
    },
  },

  methods: {
    doFilter() {
      this.$emit('vt-filter-set', this.filter);
    },

    resetFilter() {
      this.$emit('vt-filter-reset');
    },

    loadApplied() {
      this.items = [];
      Object.keys(this.filter).forEach((key) => {
        if (Array.isArray(this.filter[key]) && this.filterRefs) {
          const stores = this.filterRefs[key].reduce<string[]>((acc, item) => {
            if (this.filter[key].includes(item.id)) acc.push(item.name);
            return acc;
          }, []);
          this.items = this.items.concat(stores);
        } else if (!['recent'].includes(key)) this.items.push(this.filter[key]);
      });
      this.items = this.items.filter((item) => item);
    },

    onInchikey(inchikey: string) {
      this.filter.inchikey = inchikey;
    },
  },
});
</script>
