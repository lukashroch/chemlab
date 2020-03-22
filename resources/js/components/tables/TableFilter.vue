<template>
  <div v-if="loaded" class="card-header">
    <div class="form-group form-row">
      <div class="col-12 col-sm mb-2 mb-sm-0 d-inline-flex">
        <button type="button" class="btn btn-warning mr-2" @click="resetFilter">
          <span class="fas fa-times" :title="$t('common.search.clear')"></span>
        </button>
        <label class="sr-only">{{ $t('common.search._') }}</label>
        <typeahead v-model="filter.text" @submit="doFilter"></typeahead>
      </div>
      <template v-for="(select, key) in filterRefs">
        <div :key="key" :class="key === 'store' ? 'col-sm-4' : 'col-sm-2'">
          <multiselect
            v-model="filter[key]"
            :options="select"
            :placeholder="$t(`common.filter.${key}`)"
          ></multiselect>
        </div>
      </template>
      <div class="col-sm-auto">
        <div>
          <button
            v-if="module === 'chemicals'"
            id="searchAdvanced"
            class="btn btn-outline-secondary"
            :title="$t('common.search.advanced')"
            @click="advanced = !advanced"
          >
            <span class="fas fa-ellipsis-v"></span>
          </button>
          <button
            type="button"
            class="btn btn-primary"
            :title="$t('common.search._')"
            @click="doFilter"
          >
            <span class="fas fa-search" :title="$t('common.search._')"></span>
            {{ $t('common.search._') }}
          </button>
        </div>
      </div>
    </div>
    <collapse v-if="module === 'chemicals'" class="" :active="advanced" tag="div">
      <div class="form-group form-row">
        <div class="col-md-5 col-lg-4">
          <div class="custom-control custom-checkbox ml-2 mb-2">
            <input
              id="recent"
              v-model="filter.recent"
              type="checkbox"
              name="recent"
              class="custom-control-input"
            />
            <label for="recent" class="custom-control-label">
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
            type="text"
            name="chemspider"
            class="form-control"
            :placeholder="$t('chemicals.chemspider._')"
            @keyup.enter="doFilter"
          />
        </div>
        <label class="col-form-label sr-only">{{ $t('chemicals.pubchem._') }}</label>
        <div class="col-md-5 col-lg-4">
          <input
            id="pubchem"
            v-model="filter.pubchem"
            type="text"
            name="pubchem"
            class="form-control"
            :placeholder="$t('chemicals.pubchem._')"
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
            type="text"
            name="formula"
            class="form-control"
            :placeholder="$t('chemicals.formula')"
            @keyup.enter="doFilter"
          />
        </div>
        <label class="col-form-label sr-only">{{ $t('chemicals.structure.inchikey') }}</label>
        <div class="col-md-5 col-lg-4">
          <div class="input-group">
            <input
              id="inchikey"
              v-model="filter.inchikey"
              type="text"
              name="inchikey"
              class="form-control"
              :placeholder="$t('chemicals.structure.inchikey')"
            />
            <div class="input-group-append">
              <button class="btn btn-secondary" @click="$modal.show('ketcher')">
                <span class="fas fa-fw fa-draw-polygon" :title="$t('chemicals.structure._')"></span>
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

<script>
import isEmpty from 'lodash/isEmpty';
import { mapState } from 'vuex';
import Multiselect from '../forms/Multiselect';
import Ketcher from '../modals/Ketcher';
import Typeahead from './Typeahead';

export default {
  name: 'VuetableFilter',

  components: { Ketcher, Multiselect, Typeahead },

  props: {
    count: {
      type: Number,
      default: 0
    }
  },

  data() {
    let origFilter = {
      text: null,
      recent: false
    };

    if (this.$route.meta.module === 'chemicals') {
      origFilter = {
        ...origFilter,
        ...{
          pubchem: null,
          chemspider: null,
          formula: null,
          inchikey: null
        }
      };
    }

    return {
      advanced: false,
      items: [],
      origFilter,
      filter: {}
    };
  },

  computed: {
    ...mapState({
      loaded(state) {
        return !!Object.keys(state[this.module].refs).length;
      },
      filterRefs(state) {
        return state[this.module].refs?.filter ?? {};
      },
      activeFilter(state) {
        return state[this.module].filter.data;
      }
    })
  },

  watch: {
    activeFilter: {
      handler(val) {
        this.filter = { ...(isEmpty(val) ? this.origFilter : val) };
        this.loadApplied();
      },
      immediate: true
    },
    filterRefs(val) {
      if (Object.keys(val).length) this.loadApplied();
    }
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
      Object.keys(this.filter).forEach(key => {
        if (Array.isArray(this.filter[key]) && this.filterRefs) {
          const stores = this.filterRefs[key].reduce((acc, item) => {
            if (this.filter[key].includes(item.id)) acc.push(item.name);
            return acc;
          }, []);
          this.items = this.items.concat(stores);
        } else if (!['recent'].includes(key)) this.items.push(this.filter[key]);
      });
      this.items = this.items.filter(item => item);
    },

    onInchikey(inchikey) {
      this.filter.inchikey = inchikey;
    }
  }
};
</script>
