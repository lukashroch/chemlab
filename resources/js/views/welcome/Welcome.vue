<template>
  <div class="welcome-page">
    <component :is="current" @passForgotten="onPassForgotten" @swap="onSwap"></component>
    <password-forgotten name="password-forgotten"></password-forgotten>
  </div>
</template>

<script lang="ts">
import { defineComponent } from 'vue';
import { mapGetters } from 'vuex';

import PasswordForgotten from '@/components/modals/PasswordForgotten.vue';

import Login from './Login.vue';
import Register from './Register.vue';

export default defineComponent({
  name: 'Welcome',

  components: { Login, Register, PasswordForgotten },

  data() {
    return {
      current: 'login',
    };
  },

  computed: mapGetters('user', ['loggedIn']),

  async created() {
    if (!this.loggedIn) await this.$store.dispatch('user/request');
    if (this.loggedIn) await this.$router.push({ name: 'dashboard' });
  },

  methods: {
    onSwap(page) {
      this.current = page;
    },

    onPassForgotten() {
      this.$modal.show('password-forgotten');
    },
  },
});
</script>

<style lang="scss">
.welcome-page {
  width: 100%;
  height: calc(100vh - 200px);
  display: flex;
  justify-content: center;
  align-items: center;
}

.welcome-card {
  width: 30rem;
}
</style>
