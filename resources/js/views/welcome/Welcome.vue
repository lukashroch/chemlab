<template>
  <div class="welcome-page">
    <component :is="current" @swap="swap"></component>
  </div>
</template>

<script lang="ts">
import { mapState } from 'pinia';
import { defineComponent, ref } from 'vue';

import { useUser } from '@/stores';

import Login from './Login.vue';
import Register from './Register.vue';

export default defineComponent({
  name: 'Welcome',

  components: { Login, Register },

  setup() {
    const current = ref('login');

    const swap = (page: string) => {
      current.value = page;
    };

    return { current, swap };
  },

  computed: mapState(useUser, ['loaded']),

  async created() {
    if (!this.loaded) await useUser().request();
    if (this.loaded) await this.$router.push({ name: 'dashboard' });
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
