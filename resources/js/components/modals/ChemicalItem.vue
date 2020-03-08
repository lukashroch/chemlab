<template>
  <modal :name="name" @before-open="beforeOpen" height="auto" :scrollable="true" :pivot-y="0.25">
    <div class="modal-header">
      <h4 class="modal-title">{{ $t('chemicals.items._') }}</h4>
      <close :name="name"></close>
    </div>
    <form @submit.prevent="onSubmit">
      <div class="modal-body">
        <div class="form-group form-row">
          <label class="col-form-label col-3" for="amount">{{ $t('chemicals.amount') }}</label>
          <div class="col d-inline-flex">
            <div class="input-group">
              <input
                type="text"
                id="amount"
                name="amount"
                v-model="form.amount"
                class="form-control"
                :placeholder="$t('chemicals.amount')"
              />
              <div class="input-group-middle">
                <span class="input-group-text">
                  <span class="fas fa-fw fa-balance-scale"></span>
                </span>
              </div>
              <select
                id="unit"
                v-model="form.unit"
                name="unit"
                class="form-control custom-select"
                :placeholder="$t('chemicals.unit')"
                @change="form.errors.clear('unit')"
              >
                <option v-for="unit in units" :key="unit.id" :value="unit.id">
                  {{ unit.name }}
                </option>
              </select>
            </div>
            <error :msg="form.errors.get('amount')"></error>
            <error :msg="form.errors.get('unit')"></error>
          </div>
        </div>
        <div v-if="isCreate" class="form-group form-row">
          <label class="col-form-label col-3" for="store_id">{{ $t('common.count') }}</label>
          <div class="col-auto">
            <select
              id="count"
              v-model="form.count"
              name="count"
              class="form-control custom-select"
              @change="form.errors.clear('count')"
            >
              <option v-for="num in counts" :key="num" :value="num">
                {{ num }}
              </option>
            </select>
            <error :msg="form.errors.get('count')"></error>
          </div>
        </div>
        <div class="form-group form-row">
          <label class="col-form-label col-3" for="store_id">{{ $t('stores.title') }}</label>
          <div class="col">
            <select
              id="store_id"
              v-model="form.store_id"
              name="store_id"
              class="form-control custom-select"
              @change="form.errors.clear('store_id')"
            >
              <option v-for="store in refs.stores" :key="store.id" :value="store.id">
                {{ store.name }}
              </option>
            </select>
            <error :msg="form.errors.get('store_id')"></error>
          </div>
        </div>
        <div class="form-group form-row">
          <label class="col-form-label col-3" for="owner_id">{{ $t('chemicals.owner') }}</label>
          <div class="col">
            <select
              id="owner_id"
              v-model="form.owner_id"
              name="owner_id"
              class="form-control custom-select"
              @change="form.errors.clear('owner_id')"
            >
              <option v-for="user in refs.users" :key="user.id" :value="user.id">
                {{ user.name }}
              </option>
            </select>
            <error :msg="form.errors.get('owner_id')"></error>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" @click.stop="close()">
          <span class="fas fa-fw fa-times" :title="$t('common.cancel')"></span>
          {{ $t('common.cancel') }}
        </button>
        <button type="submit" class="btn btn-primary" :disabled="form.hasErrors()">
          <span class="fas fa-fw fa-save" :title="$t('common.save')"></span>
          {{ $t('common.save') }}
        </button>
      </div>
    </form>
  </modal>
</template>

<script>
import Form from '../../utilities/Form';
import Error from '../forms/Error';
import ModalMixin from './ModalMixin';

export default {
  name: 'ChemicalItem',

  components: { Error },

  mixins: [ModalMixin],

  props: {
    refs: {
      type: Object,
      required: true
    }
  },

  data() {
    return {
      form: new Form({
        id: null,
        chemical_id: this.$route.params.id,
        store_id: null,
        owner_id: null,
        amount: null,
        unit: 1,
        count: 1
      }),
      counts: [1, 2, 3, 4, 5],
      units: [
        { id: 1, name: 'G' },
        { id: 2, name: 'mL' },
        { id: 3, name: this.$t('chemicals.unit') },
        { id: 0, name: this.$t('common.none') }
      ]
    };
  },

  computed: {
    isCreate() {
      return !this.form.id;
    }
  },

  methods: {
    beforeOpen(event) {
      const { item } = event.params;
      if (!item) this.form.reset();
      else this.form.load(item);
    },

    async onSubmit() {
      const { id } = this.form;
      if (id) {
        const { data } = await this.form.put(`chemical-items/${id}`);
        this.$emit('update', data);
      } else {
        const { data } = await this.form.post('chemical-items');
        this.$emit('store', data);
      }
      this.close();
    }
  }
};
</script>

<style lang="scss">
.cursor {
  cursor: pointer;
}

.input-group-middle {
  margin-left: -1px;
  margin-right: -1px;
  display: flex;

  .input-group-text {
    border-radius: 0 !important;
  }
}
</style>
