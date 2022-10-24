<template>
  <div class="card mt-3">
    <div class="card-header pb-3">
      <div class="row align-items-center">
        <div class="col">
          <h5>
            <span class="fas fa-fw fa-cubes" :title="$t('chemicals.items.index').toString()"></span>
            {{ $t('chemicals.items.index') }}
          </h5>
        </div>
        <div v-if="can({ action: 'create' })" class="col-auto">
          <button
            class="btn bt-sm btn-primary"
            :title="$t('chemicals.items.create').toString()"
            type="button"
            @click="$modal.show('chemical-item', {})"
          >
            <span class="fas fa-fw fa-plus"></span>
            <span class="d-none d-md-inline-flex">{{ $t('chemicals.items.create') }}</span>
          </button>
        </div>
      </div>
    </div>
    <table class="table table-sm table-hover table-list">
      <thead>
        <tr>
          <th>{{ $t('chemicals.amount') }}</th>
          <th>{{ $t('stores.title') }}</th>
          <th>{{ $t('common.date') }}</th>
          <th>{{ $t('chemicals.owner') }}</th>
          <th class="text-center">{{ $t('common.action') }}</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="item in items" :key="item.id">
          <td>
            <span class="fas fa-fw fa-cube" :title="$t('chemicals.items._').toString()"></span>
            {{ `${item.amount} ${units[item.unit]}` }}
          </td>
          <td>{{ item.store.tree_name }}</td>
          <td>{{ $d(new Date(item.created_at), 'short') }}</td>
          <td>{{ item.owner ? item.owner.name : $t('common.not.assigned') }}</td>
          <td>
            <button
              v-if="item.perm.edit"
              class="btn btn-sm btn-primary"
              :title="$t('common.edit').toString()"
              type="button"
              @click="$modal.show('chemical-item', { item })"
            >
              <span class="fas fa-fw fa-pencil-alt"></span>
            </button>
            <button
              v-if="item.perm.edit"
              class="btn btn-sm btn-danger"
              :title="$t('common.delete').toString()"
              type="button"
              @click.stop="remove(item)"
            >
              <span class="fas fa-fw fa-trash-alt"></span>
            </button>
          </td>
        </tr>
      </tbody>
    </table>
    <chemical-item
      name="chemical-item"
      :chemicalId="chemicalId"
      :refs="refs"
      @store="store"
      @update="update"
    ></chemical-item>
  </div>
</template>

<script lang="ts">
import { mapState } from 'pinia';
import { defineComponent } from 'vue';

import type { Dictionary } from '@/types';
import { ChemicalItem } from '@/components/modals';
import { useEntry } from '@/stores';

export type ChemicalEntryItem = {
  id: number;
  chemical_id: number;
  store_id: number;
  store: Dictionary;
  unit: number;
  amount: number;
  ownerId: number;
  owner: Dictionary | null;
  perm: {
    edit: boolean;
    delete: boolean;
  };
  created_at: Date;
};

export default defineComponent({
  name: 'ChemicalItems',

  components: { ChemicalItem },

  props: {
    chemicalId: {
      type: [Number, String],
      required: true,
    },
  },

  data() {
    return {
      items: [] as ChemicalEntryItem[],
      units: ['', 'G', 'mL', this.$t('chemicals.unit')],
    };
  },

  computed: {
    ...mapState(useEntry, {
      entry: 'data',
      entryLoaded: 'dataLoaded',
      refs: 'refs',
      refsLoaded: 'refsLoaded',
    }),
  },

  watch: {
    entry: {
      handler() {
        const { items } = this.entry;
        this.items = items ? [...items] : [];
      },
      immediate: true,
    },
  },

  methods: {
    store(items: ChemicalEntryItem[]) {
      const {
        amount,
        unit,
        store: { tree_name },
      } = items[0];
      const name = `${amount} ${this.units[unit]} | ${tree_name}`;
      this.items = this.items.concat(items);
      this.$toasted.success(this.$t(`common.msg.stored`, { name }).toString());
    },

    update(item: ChemicalEntryItem) {
      const {
        id,
        amount,
        unit,
        store: { tree_name },
      } = item;

      const name = `${amount} ${this.units[unit]} | ${tree_name}`;
      const index = this.items.findIndex((i) => i.id === id);
      if (index !== -1) this.items.splice(index, 1, item);

      this.$toasted.success(this.$t(`common.msg.updated`, { name }).toString());
    },

    async remove(item: ChemicalEntryItem) {
      const {
        id,
        amount,
        unit,
        store: { tree_name },
      } = item;
      const name = `${amount} ${this.units[unit]} | ${tree_name}`;

      if (!confirm(this.$t('common.confirm.delete', { name }).toString())) return;

      await this.$http.delete(`chemical-items/${id}`);
      this.items = this.items.filter((item) => item.id !== id);
      this.$toasted.success(this.$t(`common.msg.deleted`, { name }).toString());
    },
  },
});
</script>

<style lang="scss" scoped></style>
