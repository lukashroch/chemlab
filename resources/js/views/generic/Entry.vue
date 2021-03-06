<template>
  <div>
    <div class="card mb-4">
      <div class="card-body">
        <div class="row justify-content-between">
          <div class="col-auto">
            <router-link
              tag="button"
              class="btn btn-secondary"
              :to="{ name: module }"
              :title="$t(`common.back`)"
            >
              <span class="fas fa-arrow-left" :title="$t(`common.back`)"></span>
              {{ $t(`common.back`) }}
            </router-link>
          </div>
          <div class="col">
            <template v-if="module === 'chemicals'">
              <open-modal
                name="chemical-data"
                :label="$t('chemicals.data._')"
                icon="fas fa-search"
              ></open-modal>
              <chemical-data name="chemical-data" :chemical-data="chemicalData"></chemical-data>
            </template>
          </div>
          <div class="col-auto" v-if="!isCreate">
            <delete v-if="canDo('delete')" @action="onAction"></delete>
          </div>
        </div>
      </div>
    </div>
    <div class="card">
      <div class="card-header">
        <ul class="nav nav-tabs card-header-tabs" role="tablist">
          <li v-for="tab in tabs" :key="tab" class="nav-item">
            <router-link
              tag="a"
              class="nav-link"
              exact-active-class="active"
              :to="{ name: `${module}.${tab}`, params: { id } }"
            >
              {{ $t(`common.${tab}`) }}
            </router-link>
          </li>
        </ul>
      </div>
      <div class="tab-content">
        <router-view @chemical-data-entry="onChemicalDataEntry"></router-view>
      </div>
    </div>
    <router-view name="addons"></router-view>
  </div>
</template>

<script>
import upperFirst from 'lodash/upperFirst';
import { mapGetters } from 'vuex';
import hasEntry from './hasEntry';
import mapEntry from './mapEntry';
import mapRefs from './mapRefs';
import resources from '../../router/resources';
import Delete from '../../components/toolbar/Delete';
import OpenModal from '../../components/toolbar/OpenModal';
import ChemicalData from '../../components/modals/ChemicalData';

export default {
  name: 'Entry',

  components: { Delete, OpenModal, ChemicalData },

  mixins: [hasEntry, mapEntry, mapRefs],

  data() {
    return {
      chemicalData: {},
    };
  },

  computed: {
    ...mapGetters('loading', ['isLoading']),
    tabs() {
      if (this.isCreate) return ['create'];

      const modules = [];
      Object.keys(resources).forEach((group) => modules.push(...resources[group].items));
      let { routes } = modules.find((item) => item.name === this.module);
      routes = routes.filter((item) => item !== 'create' && this.canDo(item));
      routes.push(
        ...routes.splice(
          routes.findIndex((v) => v === 'audit'),
          1
        )
      );
      return routes;
    },
    isCreate() {
      return this.$route.name === `${this.module}.create`;
    },
  },

  watch: {
    $route() {
      this.fetch();
    },
  },

  async created() {
    this.fetch();
  },

  methods: {
    onChemicalDataEntry(data) {
      this.chemicalData = { ...data };
    },

    async fetch() {
      const { path } = this.$route;
      await this.$store.dispatch(`${this.module}/entry/request`, { path });
    },

    canDo(action) {
      if (['structure'].includes(action)) action = 'edit';

      const { perm = {} } = this.entry;
      if (action in perm) return perm[action];

      return this.can({ action });
    },

    onAction(action) {
      this[`on${upperFirst(action)}`]();
    },

    async onDelete() {
      const { name } = this.entry;
      if (!confirm(this.$t('common.confirm.delete', { name }))) return;

      await this.$http.delete(`${this.module}/${this.id}`);
      this.$toasted.success(this.$t(`common.msg.deleted`, { name }));
      this.$router.push({ name: this.module });
    },
  },
};
</script>
