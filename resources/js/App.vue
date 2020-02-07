<template>
  <div class="app" :class="{ 'sidebar-open': showSidebar }">
    <loader :show="isLoading"></loader>
    <scroll-top></scroll-top>
    <sidebar v-if="loggedIn" @click.native="toggleIfCan" />
    <div class="sidebar-overlay" @click.stop="toggleSidebar"></div>
    <section class="content">
      <navbar @toggle-sidebar="toggleSidebar" />
      <div v-if="loggedIn" class="container-fluid p-3">
        <div class="row mb-2">
          <div class="col">
            <h1 class="m-0 text-dark">{{ title }}</h1>
          </div>
        </div>
      </div>
      <div class="container-fluid p-3">
        <router-view></router-view>
      </div>
      <!-- <footer class="main-footer">
        <strong> Copyright &copy; 2012-2019 {{ $t('common.chemlab') }}.</strong>
        All rights reserved.
      </footer> -->
    </section>
  </div>
</template>

<script>
import { mapState } from 'vuex';
import Loader from './components/Loader';
import ScrollTop from './components/ScrollTop';
import Navbar from './components/navbar/Navbar';
import HasSidebar from './components/sidebar/HasSidebar';
import Sidebar from './components/sidebar/Sidebar';
import tableDefs from './components/tables/ResourceDefs';

export default {
  name: 'App',

  components: { Loader, Navbar, ScrollTop, Sidebar },

  mixins: [HasSidebar],

  computed: {
    ...mapState({
      entry(state) {
        return state[this.module] && state[this.module].entry ? state[this.module].entry.data : {};
      }
    }),
    title() {
      if (this.$route.meta.title) return this.$t(this.$route.meta.title);

      return this.entry ? this.entry.name : this.$t(`common.admin`);
    }
  },

  watch: {
    '$route.meta.module': {
      handler(val) {
        this.$store.commit('setModule', val);
      },
      deep: true,
      immediate: true
    },
    title: {
      handler: val => (document.title = val),
      immediate: true
    }
  },

  async created() {
    this.initTableDefs();
  },

  methods: {
    initTableDefs() {
      Object.values(tableDefs).forEach(res => {
        res.fields.unshift({
          name: '__checkbox',
          titleClass: 'text-center',
          dataClass: 'text-center',
          width: '15px'
        });

        res.fields.push({
          name: 'actions',
          title: 'common.action._'
        });

        res.fields = res.fields.map(item => ({
          ...item,
          title: typeof item.title === 'string' ? this.$t(item.title) : item.title
        }));
      });
    }
  }
};
</script>
