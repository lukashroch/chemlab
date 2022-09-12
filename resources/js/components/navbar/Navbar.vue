<template>
  <div class="section">
    <nav class="navbar navbar-expand-sm navbar-light bg-white border-bottom">
      <ul class="navbar-nav flex-row">
        <li v-if="loaded" class="nav-item">
          <a class="nav-link" href="#" @click.prevent="$emit('toggle-sidebar')">
            <span class="fas fa-fw fa-bars"></span>
          </a>
        </li>
        <router-link v-if="!loaded" class="nav-item" tag="li" :to="{ name: 'index' }">
          <a class="nav-link" href="#">
            {{ $t('common.index') }}
          </a>
        </router-link>
      </ul>
      <ul class="navbar-nav ml-auto flex-row">
        <template v-if="!loaded">
          <router-link class="nav-item" tag="li" :to="{ name: 'index' }">
            <a class="nav-link" href="#">
              <span class="fas fa-fw fa-sign-in-alt"></span>
              {{ $t('common.login') }}
            </a>
          </router-link>
        </template>
        <template v-if="loaded">
          <router-link class="nav-item" tag="li" :to="{ name: 'profile' }">
            <a class="nav-link">
              <span class="fas fa-fw fa-user"></span>
              {{ $t('common.profile') }}
            </a>
          </router-link>
          <li class="nav-item" @click="onLogout()">
            <a class="nav-link" href="#">
              <span class="fas fa-fw fa-sign-out-alt"></span>
              {{ $t('common.logout') }}
            </a>
          </li>
        </template>
      </ul>
    </nav>
  </div>
</template>

<script lang="ts">
import { mapState } from 'pinia';
import { defineComponent } from 'vue';

import { useUser } from '@/stores';

export default defineComponent({
  name: 'Navbar',

  computed: mapState(useUser, ['loaded']),

  methods: {
    async onLogout() {
      await this.$http.post('logout');
      useUser().logout();
      await this.$router.push({ name: 'index' });
    },
  },
});
</script>
