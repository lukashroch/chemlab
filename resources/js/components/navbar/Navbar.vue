<template>
  <div class="section">
    <nav class="navbar navbar-expand-sm navbar-light bg-white border-bottom">
      <ul class="navbar-nav flex-row">
        <li v-if="loaded" class="nav-item">
          <a class="nav-link" href="#" @click.prevent="$emit('toggle-sidebar')">
            <span class="fas fa-bars"></span>
          </a>
        </li>
        <router-link v-if="!loaded" :to="{ name: 'index' }">
          <li class="nav-item">
            <a class="nav-link" href="#">{{ $t('common.index') }}</a>
          </li>
        </router-link>
      </ul>
      <ul class="navbar-nav ms-auto flex-row">
        <template v-if="!loaded">
          <router-link :to="{ name: 'index' }">
            <li class="nav-item">
              <a class="nav-link" href="#">
                <span class="fas fa-sign-in-alt"></span>
                {{ $t('common.login') }}
              </a>
            </li>
          </router-link>
        </template>
        <template v-if="loaded">
          <router-link :to="{ name: 'profile' }">
            <li class="nav-item">
              <a class="nav-link">
                <span class="fas fa-user"></span>
                {{ $t('common.profile') }}
              </a>
            </li>
          </router-link>
          <li class="nav-item" @click="logout">
            <a class="nav-link" href="#">
              <span class="fas fa-sign-out-alt"></span>
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

  emits: ['toggle-sidebar'],

  computed: mapState(useUser, ['loaded']),

  methods: {
    async logout() {
      await this.$http.post('logout');
      useUser().logout();
      await this.$router.push({ name: 'index' });
    },
  },
});
</script>
