<template>
  <div class="section">
    <nav class="navbar navbar-expand-sm navbar-light bg-white border-bottom">
      <ul class="navbar-nav flex-row">
        <li v-if="loggedIn" class="nav-item">
          <a class="nav-link" href="#" @click.prevent="$emit('toggle-sidebar')">
            <span class="fas fa-fw fa-bars"></span>
          </a>
        </li>
        <router-link v-if="!loggedIn" class="nav-item" tag="li" :to="{ name: 'index' }">
          <a class="nav-link" href="#">
            {{ $t('common.index') }}
          </a>
        </router-link>
      </ul>
      <ul class="navbar-nav ml-auto flex-row">
        <template v-if="!loggedIn">
          <router-link class="nav-item" tag="li" :to="{ name: 'index' }">
            <a class="nav-link" href="#">
              <span class="fas fa-fw fa-sign-in-alt"></span>
              {{ $t('common.login') }}
            </a>
          </router-link>
        </template>
        <template v-if="loggedIn">
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

<script>
import { mapGetters } from 'vuex';

export default {
  name: 'Navbar',

  computed: mapGetters('user', ['loggedIn']),

  methods: {
    async onLogout() {
      await this.$http.post('logout');
      this.$store.dispatch('user/logout');
      this.$router.push({ name: 'index' });
    },
  },
};
</script>
