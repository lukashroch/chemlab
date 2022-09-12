<template>
  <div class="welcome-page">
    <component :is="current" @passForgotten="onPassForgotten" @swap="onSwap"></component>
    <password-forgotten name="password-forgotten"></password-forgotten>
  </div>
</template>

<script lang="ts">
import { mapState } from 'pinia';
import { defineComponent } from 'vue';

import { PasswordForgotten } from '@/components/modals';
import { useUser } from '@/stores';

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

  computed: mapState(useUser, ['loaded']),

  async created() {
    if (!this.loaded) await useUser().request();
    if (this.loaded) await this.$router.push({ name: 'dashboard' });
  },

  methods: {
    onSwap(page: string) {
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
