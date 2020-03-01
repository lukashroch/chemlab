<template>
  <div class="card mt-3" v-if="isLoaded">
    <div class="card-header pb-3">
      <div class="row align-items-center">
        <div class="col">
          <h5>
            <span class="fas fa-fw fa-cubes" :title="$t('chemicals.items.index')"></span>
            {{ $t('chemicals.items.index') }}
          </h5>
        </div>
        <div class="col-auto" v-if="can({ action: 'create' })">
          <button
            type="button"
            class="btn bt-sm btn-primary"
            :title="$t('chemicals.items.create')"
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
          <th class="text-center">{{ $t('common.action._') }}</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="item in items" :key="item.id">
          <td>
            <span class="fas fa-fw fa-cube" :title="$t('chemicals.items._')"></span>
            {{ `${item.amount} ${units[item.unit]}` }}
          </td>
          <td>{{ item.store.tree_name }}</td>
          <td>{{ $d(new Date(item.created_at), 'short') }}</td>
          <td>{{ item.owner ? item.owner.name : $t('common.not.assigned') }}</td>
          <td>
            <button
              type="button"
              class="btn btn-sm btn-primary"
              :title="$t('common.action.edit')"
              @click="$modal.show('chemical-item', { item })"
            >
              <span class="fas fa-fw fa-pencil-alt"></span>
            </button>
            <button
              type="button"
              class="btn btn-sm btn-danger"
              :title="$t('common.action.delete')"
              @click.stop="onDelete(item)"
            >
              <span class="fas fa-fw fa-trash-alt"></span>
            </button>
          </td>
        </tr>
      </tbody>
    </table>
    <chemical-item
      name="chemical-item"
      :refs="refs"
      @store="onStore"
      @update="onUpdate"
    ></chemical-item>
  </div>
</template>

<script>
import ChemicalItem from '../../../components/modals/ChemicalItem';
import ShowMixin from '../../generic/ShowMixin';

export default {
  name: 'Items',

  components: { ChemicalItem },

  mixins: [ShowMixin],

  data() {
    return {
      items: [],
      units: ['', 'G', 'mL', this.$t('chemicals.unit')]
    };
  },

  watch: {
    entry() {
      const { items } = this.entry;
      this.items = items ? [...items] : [];
    }
  },

  methods: {
    onStore(items) {
      const {
        amount,
        unit,
        store: { tree_name }
      } = items[0];
      const name = `${amount} ${this.units[unit]} | ${tree_name}`;
      this.items = this.items.concat(items);
      this.$toasted.success(this.$t(`common.msg.stored`, { name }));
    },

    onUpdate(item) {
      const {
        id,
        amount,
        unit,
        store: { tree_name }
      } = item;
      const name = `${amount} ${this.units[unit]} | ${tree_name}`;
      const index = this.items.findIndex(i => i.id === id);
      if (index !== -1) this.items.splice(index, 1, item);
      this.$toasted.success(this.$t(`common.msg.updated`, { name }));
    },

    async onDelete(item) {
      const {
        id,
        amount,
        unit,
        store: { tree_name }
      } = item;
      const name = `${amount} ${this.units[unit]} | ${tree_name}`;
      if (!confirm(this.$t('common.action.confirm.delete', { name }))) return;

      await this.$http.delete(`chemical-items/${id}`);
      this.items = this.items.filter(item => item.id !== id);
      this.$toasted.success(this.$t(`common.msg.deleted`, { name }));
    }
  }
};
</script>

<style lang="scss" scoped></style>
