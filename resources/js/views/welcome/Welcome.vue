<template>
  <div class="welcome-page">
    <component :is="current" @swap="onSwap" @passForgotten="onPassForgotten"></component>
    <password-forgotten name="password-forgotten"></password-forgotten>
  </div>
</template>

<script>
import PasswordForgotten from '../../components/modals/PasswordForgotten';
import Login from './Login';
import Register from './Register';
import { mapGetters } from 'vuex';

export default {
  name: 'Welcome',

  components: { Login, Register, PasswordForgotten },

  data() {
    return {
      current: 'login'
    };
  },

  computed: mapGetters('user', ['loggedIn']),

  async created() {
    if (!this.loggedIn) await this.$store.dispatch('user/request');
    if (this.loggedIn) this.$router.push({ name: 'dashboard' });
  },

  methods: {
    onSwap(page) {
      this.current = page;
    },

    onPassForgotten() {
      this.$modal.show('password-forgotten');
    }
  }
};
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
