<template>
  <div class="app" :class="{ 'sidebar-open': showSidebar }">
    <loader :show="isAppLoading"></loader>
    <scroll-top></scroll-top>
    <sidebar v-if="loaded" @click="toggleIfCan" />
    <div class="sidebar-overlay" @click.stop="toggleSidebar"></div>
    <section class="content">
      <navbar @toggle-sidebar="toggleSidebar" />
      <div v-if="loaded" class="container-fluid p-3">
        <div class="row mb-2">
          <div class="col">
            <h1 class="m-0 text-dark">{{ title }}</h1>
          </div>
        </div>
      </div>
      <div class="container-fluid px-3 pt-3 pb-5">
        <router-view></router-view>
      </div>
      <notifications></notifications>
      <!-- <footer class="main-footer">
        <strong> Copyright &copy; 2012-2019 {{ $t('common.index') }}.</strong>
        All rights reserved.
      </footer> -->
    </section>
  </div>
</template>

<script lang="ts">
import { mapState } from 'pinia';
import { defineComponent } from 'vue';

import Loader from './components/Loader.vue';
import Navbar from './components/navbar/Navbar.vue';
import { Notifications } from './components/notifications';
import ScrollTop from './components/ScrollTop.vue';
import HasSidebar from './components/sidebar/HasSidebar';
import Sidebar from './components/sidebar/Sidebar.vue';
import { useEntry, useUser } from './stores';

export default defineComponent({
  name: 'App',

  components: { Loader, Navbar, Notifications, ScrollTop, Sidebar },

  mixins: [HasSidebar],

  computed: {
    ...mapState(useEntry, { entry: 'data' }),
    ...mapState(useUser, ['loaded']),
    title() {
      const { meta: { module, title } = {} } = this.$route;
      if (title) return this.$t(title);

      return this.entry?.name ?? this.$t(module ? `${module}.index` : `common.index`);
    },
  },

  watch: {
    title: {
      handler(val) {
        document.title = val;
      },
      immediate: true,
    },
  },

  async created() {
    this.$http.init(this.$router, useUser);
  },
});
</script>
