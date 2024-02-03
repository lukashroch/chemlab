<template>
  <div class="card mt-3">
    <div class="card-header pb-3">
      <div class="row align-items-center">
        <div class="col">
          <h5>
            <span class="fas fa-cubes" :title="$t('chemicals.items.index')"></span>
            {{ $t('chemicals.items.index') }}
          </h5>
        </div>
        <div v-if="can({ action: 'create' })" class="col-auto">
          <button
            class="btn bt-sm btn-primary"
            :title="$t('chemicals.items.create')"
            type="button"
            @click="loadItem()"
          >
            <span class="fas fa-plus me-1"></span>
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
            <span class="fas fa-cube" :title="$t('chemicals.items._')"></span>
            {{ `${item.amount} ${units[item.unit]}` }}
          </td>
          <td>{{ item.store.tree_name }}</td>
          <td>{{ $d(new Date(item.created_at), 'short') }}</td>
          <td>{{ item.owner ? item.owner.name : $t('common.not.assigned') }}</td>
          <td>
            <button
              v-if="item.perm.edit"
              class="btn btn-sm btn-primary me-1"
              :title="$t('common.edit')"
              type="button"
              @click="loadItem(item)"
            >
              <span class="fas fa-pencil-alt"></span>
            </button>
            <button
              v-if="item.perm.edit"
              class="btn btn-sm btn-danger"
              :title="$t('common.delete')"
              type="button"
              @click.stop="remove(item)"
            >
              <span class="fas fa-trash-alt"></span>
            </button>
          </td>
        </tr>
      </tbody>
    </table>
    <chemical-item
      ref="chemicalItem"
      v-bind="{ chemicalId, refs }"
      @store="store"
      @update="update"
    ></chemical-item>
  </div>
</template>

<script lang="ts">
import { mapState } from 'pinia';
import { defineComponent, ref } from 'vue';
import { useI18n } from 'vue-i18n';

import type { ChemicalEntryItem } from '@/types';
import { ChemicalItem } from '@/components/modals';
import { useEntry, useMessages } from '@/stores';

export default defineComponent({
  name: 'ChemicalItems',

  components: { ChemicalItem },

  props: {
    chemicalId: {
      type: [Number, String],
      required: true,
    },
  },

  setup() {
    const { t } = useI18n();

    const chemicalItem = ref<InstanceType<typeof ChemicalItem>>();
    const items = ref<ChemicalEntryItem[]>([]);
    const units = ['', 'G', 'mL', t('chemicals.unit')];

    function loadItem(item?: ChemicalEntryItem) {
      chemicalItem.value?.load(item);
    }

    return {
      chemicalItem,
      items,
      loadItem,
      units,
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
      this.items.push(...items);
      useMessages().success(this.$t(`common.msg.stored`, { name }));
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

      useMessages().success(this.$t(`common.msg.updated`, { name }));
    },

    async remove(item: ChemicalEntryItem) {
      const {
        id,
        amount,
        unit,
        store: { tree_name },
      } = item;
      const name = `${amount} ${this.units[unit]} | ${tree_name}`;

      if (!confirm(this.$t('common.confirm.delete', { name }))) return;

      await this.$http.delete(`chemical-items/${id}`);
      this.items = this.items.filter((item) => item.id !== id);
      useMessages().success(this.$t(`common.msg.deleted`, { name }));
    },
  },
});
</script>

<style lang="scss" scoped></style>
