<template>
  <div class="tab-pane active">
    <form @submit.prevent="onSubmit" @keydown="form.errors.clear($event.target.name)">
      <div class="card-body">
        <div class="form-group form-row">
          <label for="name" class="col-md-2 col-form-label">{{ $t('common.title') }}</label>
          <div class="col-md-10">
            <input
              id="name"
              v-model="form.name"
              type="text"
              name="name"
              class="form-control"
              :placeholder="$t('common.title')"
            />
            <error :msg="form.errors.get('name')"></error>
          </div>
        </div>
        <div class="form-group form-row">
          <label for="iupac_name" class="col-md-2 col-form-label">{{
            $t('chemicals.iupac')
          }}</label>
          <div class="col-md-10">
            <input
              id="iupac_name"
              v-model="form.iupac_name"
              type="text"
              name="iupac_name"
              class="form-control"
              :placeholder="$t('chemicals.iupac')"
            />
            <error :msg="form.errors.get('iupac_name')"></error>
          </div>
        </div>
        <div class="form-group form-row">
          <label for="synonym" class="col-md-2 col-form-label">{{ $t('chemicals.synonym') }}</label>
          <div class="col-md-10">
            <input
              id="synonym"
              v-model="form.synonym"
              type="text"
              name="synonym"
              class="form-control"
              :placeholder="$t('chemicals.synonym')"
            />
            <error :msg="form.errors.get('synonym')"></error>
          </div>
        </div>

        <div class="form-group form-row">
          <label for="catalog_id" class="col-md-2 col-form-label">{{
            $t('chemicals.brand.id')
          }}</label>
          <div class="col-md-4">
            <input
              id="catalog_id"
              v-model="form.catalog_id"
              type="text"
              name="catalog_id"
              class="form-control"
              :placeholder="$t('chemicals.brand.id')"
            />
            <error :msg="form.errors.get('catalog_id')"></error>
          </div>
          <label for="brand_id" class="col-md-2 col-form-label">{{
            $t('chemicals.brand._')
          }}</label>
          <div class="col-md-4">
            <select
              id="brand_id"
              v-model="form.brand_id"
              name="brand_id"
              class="form-control custom-select"
              @change="form.errors.clear('brand_id')"
            >
              <option v-for="brands in refs.brands" :key="brands.id" :value="brands.id">{{
                brands.name
              }}</option>
            </select>
            <error :msg="form.errors.get('brand_id')"></error>
          </div>
        </div>
        <div class="form-group form-row">
          <label for="cas" class="col-md-2 col-form-label">{{ $t('chemicals.cas') }}</label>
          <div class="col-md-4">
            <input
              id="cas"
              v-model="form.cas"
              type="text"
              name="cas"
              class="form-control"
              :placeholder="$t('chemicals.cas')"
            />
            <error :msg="form.errors.get('cas')"></error>
          </div>
          <label for="pubchem" class="col-md-2 col-form-label">{{
            $t('chemicals.pubchem._')
          }}</label>
          <div class="col-md-4">
            <input
              id="pubchem"
              v-model="form.pubchem"
              type="text"
              name="pubchem"
              class="form-control"
              :placeholder="$t('chemicals.pubchem')"
            />
            <error :msg="form.errors.get('pubchem._')"></error>
          </div>
        </div>
        <div class="form-group form-row">
          <label for="mw" class="col-md-2 col-form-label">{{ $t('chemicals.mw') }}</label>
          <div class="col-md-4">
            <input
              id="mw"
              v-model="form.mw"
              type="text"
              name="mw"
              class="form-control"
              :placeholder="$t('chemicals.mw')"
            />
            <error :msg="form.errors.get('mw')"></error>
          </div>
          <label for="formula" class="col-md-2 col-form-label">{{ $t('chemicals.formula') }}</label>
          <div class="col-md-4">
            <input
              id="formula"
              v-model="form.formula"
              type="text"
              name="formula"
              class="form-control"
              :placeholder="$t('chemicals.formula')"
            />
            <error :msg="form.errors.get('formula')"></error>
          </div>
        </div>
        <div class="form-group form-row">
          <label for="chemspider" class="col-md-2 col-form-label">{{
            $t('chemicals.chemspider._')
          }}</label>
          <div class="col-md-4">
            <input
              id="chemspider"
              v-model="form.chemspider"
              type="text"
              name="chemspider"
              class="form-control"
              :placeholder="$t('chemicals.chemspider._')"
            />
            <error :msg="form.errors.get('chemspider')"></error>
          </div>
        </div>
        <div class="form-group form-row">
          <label for="description" class="col-form-label col-md-2">{{
            $t('common.description')
          }}</label>
          <div class="col-md-10">
            <textarea
              id="description"
              v-model="form.description"
              name="description"
              class="form-control"
              rows="4"
              :placeholder="$t('common.description')"
            ></textarea>
            <error :msg="form.errors.get('description')"></error>
          </div>
        </div>
        <!-- SDS Info -->
        <div class="form-group form-row">
          <label for="symbol" class="col-md-2 col-form-label">{{ $t('msds.symbol') }}</label>
          <div class="col-md-4">
            <multiselect
              id="symbols"
              v-model="form.symbol"
              :options="symbols"
              @input="form.errors.clear('symbol')"
            ></multiselect>
            <error :msg="form.errors.get('symbol')"></error>
          </div>
          <label for="signal_word" class="col-md-2 col-form-label">{{
            $t('msds.signal_word')
          }}</label>
          <div class="col-md-4">
            <input
              id="signal_word"
              v-model="form.signal_word"
              type="text"
              name="signal_word"
              class="form-control"
              :placeholder="$t('msds.signal_word')"
            />
            <error :msg="form.errors.get('signal_word')"></error>
          </div>
        </div>

        <div class="form-group form-row">
          <label for="h" class="col-md-2 col-form-label">{{ $t('msds.h_abbr') }}</label>
          <div class="col-md-4">
            <multiselect
              id="h"
              v-model="form.h"
              :options="hOptions"
              @input="form.errors.clear('h')"
            ></multiselect>
            <error :msg="form.errors.get('h')"></error>
          </div>
          <label for="p" class="col-md-2 col-form-label">{{ $t('msds.p_abbr') }}</label>
          <div class="col-md-4">
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
      <submit-footer :disabled="form.errors.any()"></submit-footer>
    </form>
  </div>
</template>

<script>
import debounce from 'lodash/debounce';
import Multiselect from '../../components/forms/Multiselect';
import Form from '../../utilities/Form';
import FormMixin from '../generic/FormMixin';

export default {
  name: 'Form',

  components: { Multiselect },

  mixins: [FormMixin],

  data() {
    return {
      form: new Form({
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
          smiles: null
        },
        signal_word: null,
        h: [],
        p: [],
        r: [],
        s: [],
        symbol: []
      })
    };
  },

  computed: {
    symbols() {
      return this.formatOptions(this.$t('msds.symbols'));
    },
    hOptions() {
      return this.formatOptions(this.$t('msds.h'));
    },
    pOptions() {
      return this.formatOptions(this.$t('msds.p'));
    }
  },

  watch: {
    'form.brand_id': {
      handler() {
        this.debouncedcheckBrand();
      },
      deep: true
    },
    'form.catalog_id': {
      handler() {
        this.debouncedcheckBrand();
      },
      deep: true
    }
  },

  created() {
    this.debouncedcheckBrand = debounce(this.checkBrand, 500);
  },

  methods: {
    formatOptions(items) {
      const options = [];
      for (const [id, name] of Object.entries(items)) {
        options.push({ id, name });
      }
      return options;
    },

    async checkBrand() {
      const { id, brand_id, catalog_id } = this.form;
      try {
        await this.$http.post(
          'chemicals/check-brand',
          { id, brand_id, catalog_id },
          { withErr: true }
        );
      } catch (err) {
        if (err.response?.status === 422) this.form.errors.record(err.response?.data?.errors);
      }
    }
  }
};
</script>

<style scoped></style>
