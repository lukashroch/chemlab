<template>
  <vue-final-modal
    v-model="dialog"
    class="d-flex justify-content-center align-items-center"
    content-class="bg-white rounded chemical-item-dialog"
  >
    <div class="d-flex justify-content-between align-items-center px-4 py-2 border border-bottom">
      <h5 class="mb-0">{{ $t('chemicals.items._') }}</h5>
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
      <form @submit.prevent="submit">
        <div class="container-fluid">
          <div class="row mb-3">
            <label class="col-form-label col-3" for="amount">{{ $t('chemicals.amount') }}</label>
            <div class="col d-inline-flex">
              <div class="input-group">
                <input
                  id="amount"
                  v-model="form.amount"
                  class="form-control"
                  name="amount"
                  :placeholder="$t('chemicals.amount')"
                  type="text"
                />
                <span class="input-group-text">
                  <span class="fas fa-balance-scale"></span>
                </span>
                <select
                  id="unit"
                  v-model="form.unit"
                  class="form-select"
                  name="unit"
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
          <div v-if="isCreate" class="row mb-3">
            <label class="col-form-label col-3" for="store_id">{{ $t('common.count') }}</label>
            <div class="col-auto">
              <select
                id="count"
                v-model="form.count"
                class="form-select"
                name="count"
                @change="form.errors.clear('count')"
              >
                <option v-for="num in counts" :key="num" :value="num">
                  {{ num }}
                </option>
              </select>
              <error :msg="form.errors.get('count')"></error>
            </div>
          </div>
          <div class="row mb-3">
            <label class="col-form-label col-3" for="store_id">{{ $t('stores.title') }}</label>
            <div class="col">
              <select
                id="store_id"
                v-model="form.store_id"
                class="form-select"
                name="store_id"
                @change="form.errors.clear('store_id')"
              >
                <option v-for="store in refs.stores" :key="store.id" :value="store.id">
                  {{ store.name }}
                </option>
              </select>
              <error :msg="form.errors.get('store_id')"></error>
            </div>
          </div>
          <div class="row mb-3">
            <label class="col-form-label col-3" for="owner_id">{{ $t('chemicals.owner') }}</label>
            <div class="col">
              <select
                id="owner_id"
                v-model="form.owner_id"
                class="form-select"
                name="owner_id"
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
        <div class="d-flex justify-content-end">
          <button class="btn btn-secondary me-1" type="button" @click.stop="close">
            <span class="fas fa-times me-1" :title="$t('common.cancel')"></span>
            {{ $t('common.cancel') }}
          </button>
          <button class="btn btn-primary" :disabled="form.hasErrors()" type="submit">
            <span class="fas fa-save me-1" :title="$t('common.save')"></span>
            {{ $t('common.save') }}
          </button>
        </div>
      </form>
    </div>
  </vue-final-modal>
</template>

<script lang="ts">
import { computed, defineComponent, reactive, ref } from 'vue';
import { VueFinalModal } from 'vue-final-modal';
import { useI18n } from 'vue-i18n';

import type { ChemicalEntryItem } from '@/types';
import { Error } from '@/components/forms';
import { createForm } from '@/util';

export default defineComponent({
  name: 'ChemicalItem',

  components: { Error, VueFinalModal },

  props: {
    chemicalId: {
      type: [Number, String],
      required: true,
    },
    refs: {
      type: Object,
      required: true,
    },
  },

  emits: ['store', 'update'],

  setup(props, { emit }) {
    const { t } = useI18n();

    const dialog = ref(false);
    const form = reactive(
      createForm({
        id: null,
        chemical_id: props.chemicalId,
        store_id: props.refs.stores[0].id ?? null,
        owner_id: null,
        amount: null,
        unit: 1,
        count: 1,
      })
    );

    const isCreate = computed(() => !form.id);
    const counts = [1, 2, 3, 4, 5];
    const units = [
      { id: 1, name: 'G' },
      { id: 2, name: 'mL' },
      { id: 3, name: t('chemicals.unit') },
      { id: 0, name: t('common.none') },
    ];

    function close() {
      dialog.value = false;
    }

    function open() {
      dialog.value = true;
    }

    function load(item?: ChemicalEntryItem) {
      if (!item) form.reset();
      else form.load(item);

      open();
    }

    async function submit() {
      const { id } = form;
      if (id) {
        const { data } = await form.put(`chemical-items/${id}`);
        emit('update', data);
      } else {
        const { data } = await form.post('chemical-items');
        emit('store', data);
      }
      close();
    }

    return {
      counts,
      dialog,
      form,
      isCreate,
      close,
      load,
      open,
      submit,
      units,
    };
  },
});
</script>

<style lang="scss">
.chemical-item-dialog {
  max-width: 700px;
  max-height: 80vh;
}
</style>
