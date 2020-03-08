<template>
  <modal :name="name" @before-open="beforeOpen" height="auto" :scrollable="true" :pivot-y="0.25">
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
              :placeholder="$t('chemicals.data.source')"
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
                type="text"
                id="search"
                name="search"
                v-model="search"
                class="form-control"
                :placeholder="$t('chemicals.data.id')"
              />
              <div class="input-group-append">
                <button type="submit" class="btn btn-primary" :disabled="!search">
                  <span class="fas fa-fw fa-search"></span> {{ $t('common.search._') }}
                </button>
              </div>
            </div>
          </div>
        </div>
        <div class="">
          <h5 @click="showOptions = !showOptions" class="cursor">
            <span
              class="fas fa-lg fa-fw fa-caret-right"
              :class="{ 'fa-rotate-90': showOptions }"
            ></span>
            {{ $t('common.options') }}
          </h5>
          <collapse class="form-row px-2" :active="showOptions" tag="div">
            <div class="col-sm-6" v-for="option in options.list" :key="option.label">
              <div class="custom-control custom-checkbox mb-2">
                <input
                  type="checkbox"
                  class="custom-control-input"
                  :id="option.label"
                  :value="option.key"
                  v-model="options.selected"
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
          class="input-group mb-3"
          v-for="(result, key) in results.list"
          :key="key"
          v-show="!['brand_id', 'catalog_id'].includes(key)"
        >
          <div class="input-group-prepend">
            <div class="input-group-text">
              <div class="custom-control custom-checkbox">
                <input
                  type="checkbox"
                  class="custom-control-input"
                  :id="key"
                  :value="key"
                  v-model="results.selected"
                />
                <label class="custom-control-label" :for="key">{{ result.label }}</label>
              </div>
            </div>
          </div>
          <input
            type="text"
            class="form-control"
            :aria-label="result.label"
            :value="result.value"
          />
        </div>
      </div>
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-outline-secondary" @click.stop="close()">
        <span class="fas fa-fw fa-times" :title="$t('common.cancel')"></span>
        {{ $t('common.cancel') }}
      </button>
      <button
        type="button"
        class="btn btn-primary"
        :disabled="!results.selected.length"
        @click.stop="onConfirm()"
      >
        <span class="fas fa-fw fa-paste" :title="$t('common.insert')"></span>
        {{ $t('common.insert') }}
      </button>
    </div>
  </modal>
</template>

<script>
import { mapState } from 'vuex';
import * as cactusApi from '../../services/cactus.service';
import ModalMixin from './ModalMixin';
import Multiselect from '../forms/Multiselect';

export default {
  name: 'ChemicalData',

  components: { Multiselect },

  mixins: [ModalMixin],

  props: {
    chemicalData: {
      type: Object,
      required: true
    }
  },

  data() {
    const list = [
      { key: 'brand_id', call: null, label: this.$t('chemicals.brand._') },
      { key: 'catalog_id', call: null, label: this.$t('chemicals.brand.id') },
      { key: 'name', call: null, label: this.$t('chemicals.name') },
      { key: 'synonym', call: null /*'names'*/, label: this.$t('chemicals.synonym') },
      { key: 'iupac', call: 'iupac', label: this.$t('chemicals.iupac') },
      { key: 'cas', call: 'cas', label: this.$t('chemicals.cas') },
      { key: 'mw', call: 'mw', label: this.$t('chemicals.mw') },
      { key: 'formula', call: 'formula', label: this.$t('chemicals.formula') },
      { key: 'pubchem', call: null, label: this.$t('chemicals.pubchem._') },
      { key: 'description', call: null, label: this.$t('common.description') },
      { key: 'sdf', call: 'sdf', label: this.$t('chemicals.structure.sdf') },
      { key: 'smiles', call: 'smiles', label: this.$t('chemicals.structure.smiles') },
      { key: 'inchikey', call: 'inchikey', label: this.$t('chemicals.structure.inchikey') },
      { key: 'inchi', call: 'inchi', label: this.$t('chemicals.structure.inchi') },
      { key: 'symbol', call: null, label: this.$t('msds.symbol') },
      { key: 'signal_word', call: null, label: this.$t('msds.signal_word') },
      { key: 'h', call: null, label: this.$t('msds.h_abbr') },
      { key: 'p', call: null, label: this.$t('msds.p_abbr') }
    ];
    const selected = list.map(item => item.key);

    return {
      search: null,
      showOptions: false,
      sources: {
        list: [
          {
            id: 'sigma',
            name: this.$t('chemicals.data.sigma._'),
            hint: this.$t('chemicals.data.sigma.hint')
          },
          {
            id: 'cactus',
            name: this.$t('chemicals.data.cactus._'),
            hint: this.$t('chemicals.data.cactus.hint')
          }
        ],
        selected: []
      },
      options: {
        list,
        selected
      },
      results: {
        list: {},
        selected: []
      }
    };
  },

  computed: {
    ...mapState({
      entry(state) {
        return state[this.module].entry.data;
      }
    }),
    hints() {
      return this.sources.list.filter(item => this.sources.selected.includes(item.id));
    }
  },

  methods: {
    beforeOpen() {
      const { cas, catalog_id } = this.chemicalData;
      if (catalog_id) {
        this.search = catalog_id;
        this.sources.selected = ['sigma', 'cactus'];
      } else {
        this.search = cas;
        this.sources.selected = ['cactus'];
      }
    },

    async cactus(search) {
      this.options.list.forEach(item => {
        const { key, call, label } = item;
        if (!this.options.selected.includes(key) || !call) {
          return;
        }

        cactusApi[call](search)
          .then(res => {
            this.results.list = { ...this.results.list, [key]: { label, value: res } };
            if (!this.results.selected.includes(key)) this.results.selected.push(key);
          })
          .catch(err => {
            const { response: { status } = {} } = err;
            this.$toasted.error(
              status === 404
                ? this.$t('chemicals.data.cactus.not-found', { label, search })
                : err.message
            );
          });
      });
    },

    async vendor(search, callback) {
      try {
        const { data } = await this.$http.post(
          'chemicals/parse',
          { catalog_id: search, callback },
          { withErr: true }
        );
        this.options.list.forEach(item => {
          const { key, label } = item;
          if (key in data) {
            this.results.list = { ...this.results.list, [key]: { label, value: data[key] } };
            if (!this.results.selected.includes(key)) this.results.selected.push(key);
          }
        });
      } catch (err) {
        const { response: { status } = {} } = err;
        this.$toasted.error(
          status === 404 ? this.$t('chemicals.data.vendor.not-found', { search }) : err.message
        );
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
        await this.vendor(search, 'sigma-aldrich');
      }

      if (this.sources.selected.includes('cactus'))
        await this.cactus(this.results.list.cas?.value ?? search);
    },

    onConfirm() {
      if (!this.results.selected.length) {
        this.$toasted.info('No results selected.');
        return;
      }

      const toImport = Object.entries(this.results.list).reduce((acc, [key, item]) => {
        if (this.results.selected.includes(key))
          acc[key] = Array.isArray(item.value) ? item.value.join(',') : item.value;
        return acc;
      }, {});
      this.$parent.$emit('chemical-data-results', toImport);
      this.close();
    }
  }
};
</script>

<style>
.cursor {
  cursor: pointer;
}
</style>
