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
              :title="$t(`common.action.back`)"
            >
              <span class="fas fa-arrow-left" :title="$t(`common.action.back`)"></span>
              {{ $t(`common.action.back`) }}
            </router-link>
          </div>
          <template v-if="!isCreate">
            <div class="col">
              <print v-if="[].includes(module)" @action="onAction"></print>
            </div>
            <div class="col-auto">
              <delete @action="onAction"></delete>
            </div>
          </template>
        </div>
      </div>
    </div>
    <div class="card">
      <div class="card-header">
        <ul class="nav nav-tabs card-header-tabs" role="tablist">
          <template v-if="isCreate">
            <li class="nav-item">
              <router-link
                tag="a"
                class="nav-link"
                exact-active-class="active"
                :to="{ name: `${module}.create` }"
              >
                {{ $t(`common.action.create`) }}
              </router-link>
            </li>
          </template>
          <template v-else>
            <li v-for="(tab, idx) in tabs" :key="idx" class="nav-item">
              <router-link
                tag="a"
                class="nav-link"
                exact-active-class="active"
                :to="{ name: `${module}.${tab}`, params: { id } }"
              >
                {{ $t(`common.action.${tab}`) }}
              </router-link>
            </li>
          </template>
        </ul>
      </div>
      <div class="tab-content">
        <router-view></router-view>
      </div>
    </div>
    <router-view name="addons"></router-view>
  </div>
</template>

<script>
import upperFirst from 'lodash/upperFirst';
import without from 'lodash/without';
import { mapGetters } from 'vuex';
import DetailMixin from './DetailMixin';
import resources from '../../router/resources';
import Delete from '../../components/toolbar/Delete';
import Print from '../../components/toolbar/Print';
import { print } from '../../utilities/export';

export default {
  name: 'Detail',

  components: { Delete, Print },

  mixins: [DetailMixin],

  computed: {
    ...mapGetters('loading', ['isLoading']),
    tabs() {
      const modules = [];
      Object.keys(resources).forEach(group => modules.push(...resources[group].items));
      let { routes } = modules.find(item => item.name === this.module);
      routes = routes.filter(item => this.canDo(item) && this.hasRoute(`${this.module}.${item}`));
      routes.push(
        ...routes.splice(
          routes.findIndex(v => v === 'audit'),
          1
        )
      );
      return without(routes, 'create');
    },
    isCreate() {
      return this.$route.name === `${this.module}.create`;
    }
  },

  watch: {
    $route() {
      this.fetch();
    }
  },

  async created() {
    this.fetch();
  },

  methods: {
    async fetch() {
      const { path } = this.$route;
      await this.$store.dispatch(`${this.module}/entry/request`, { path });
    },

    canDo(action) {
      if (['structure'].includes(action)) action = 'edit';

      return this.can(`${this.module}-${action}`);
    },

    hasRoute(name) {
      return this.$router.resolve({ name }).resolved.matched.length;
    },

    onAction(action) {
      this[`on${upperFirst(action)}`]();
    },

    async onPrint() {
      const res = await this.$http.get(`${this.module}/${this.id}/print`);
      print(res);
    },

    async onDelete() {
      const { name } = this.entry;
      if (!confirm(this.$t('common.action.confirm.delete', { name }))) return;

      await this.$http.delete(`${this.module}/${this.id}`);
      this.$toasted.success(this.$t(`common.msg.deleted`, { name }));
      this.$router.push({ name: this.module });
    }
  }
};
</script>
