<template>
  <div>
    <div class="card mb-4">
      <div class="card-body">
        <div class="row justify-content-between">
          <div class="col-auto">
            <router-link
              class="btn btn-secondary"
              tag="button"
              :title="$t(`common.back`)"
              :to="{ name: module }"
            >
              <span class="fas fa-arrow-left" :title="$t(`common.back`).toString()"></span>
              {{ $t(`common.back`) }}
            </router-link>
          </div>
          <div class="col">
            <template v-if="module === 'chemicals'">
              <open-modal
                icon="fas fa-search"
                :label="$t('chemicals.data._').toString()"
                name="chemical-data"
              ></open-modal>
              <chemical-data :chemical-data="chemicalData" name="chemical-data"></chemical-data>
            </template>
          </div>
          <div v-if="!isCreate" class="col-auto">
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
              class="nav-link"
              exact-active-class="active"
              tag="a"
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

<script lang="ts">
import upperFirst from 'lodash/upperFirst';
import { defineComponent } from 'vue';

import { ChemicalData } from '@/components/modals';
import Delete from '@/components/toolbar/Delete.vue';
import OpenModal from '@/components/toolbar/OpenModal.vue';
import { resources } from '@/router/resources';
import { useEntry } from '@/stores';

import hasEntry from './has-entry';
import hasRefs from './has-refs';

export default defineComponent({
  name: 'Entry',

  components: { Delete, OpenModal, ChemicalData },

  mixins: [hasEntry, hasRefs],

  data() {
    return {
      chemicalData: {},
    };
  },

  computed: {
    tabs() {
      if (this.isCreate) return ['create'];

      const resource = resources.find((item) => item.name === this.module);
      if (!resource) return [];

      const routes = resource.routes.filter((item) => item !== 'create' && this.canDo(item));
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
    async $route() {
      await this.fetch();
    },
  },

  async created() {
    await this.fetch();
  },

  methods: {
    onChemicalDataEntry(data) {
      this.chemicalData = { ...data };
    },

    async fetch() {
      const { path } = this.$route;
      await useEntry().request({ path });
    },

    canDo(action: string) {
      if (['structure'].includes(action)) action = 'edit';

      const { perm = {} } = this.entry;
      if (action in perm) return perm[action];

      return this.can({ action });
    },

    onAction(action: string) {
      this[`on${upperFirst(action)}`]();
    },

    async onDelete() {
      const { name } = this.entry;
      if (!confirm(this.$t('common.confirm.delete', { name }).toString())) return;

      await this.$http.delete(`${this.module}/${this.id}`);
      this.$toasted.success(this.$t(`common.msg.deleted`, { name }).toString());
      await this.$router.push({ name: this.module });
    },
  },
});
</script>
