<template>
  <div class="container-center">
    <div class="card component-center">
      <div class="card-header">
        <h6 class="mt-4">{{ $t('users.password.change') }}</h6>
      </div>
      <form @keydown="form.errors.clear($event.target.name)" @submit.prevent="submit">
        <div class="card-body">
          <div class="form-group">
            <label v-t="'users.password.current'" for="password_current"></label>
            <input
              id="password_current"
              v-model="form.password_current"
              class="form-control"
              name="password_current"
              :placeholder="$t('users.password.current').toString()"
              type="password"
            />
            <error :msg="form.errors.get('password_current')"></error>
          </div>
          <div class="form-group">
            <label v-t="'users.password.new'" for="password"></label>
            <input
              id="password"
              v-model="form.password"
              class="form-control"
              name="password"
              :placeholder="$t('users.password.new').toString()"
              type="password"
            />
            <error :msg="form.errors.get('password')"></error>
          </div>
          <div class="form-group">
            <label v-t="'users.password.confirmation'" for="password_confirmation"></label>
            <input
              id="password_confirmation"
              v-model="form.password_confirmation"
              class="form-control"
              name="password_confirmation"
              :placeholder="$t('users.password.confirmation').toString()"
              type="password"
            />
            <error :msg="form.errors.get('password_confirmation')"></error>
          </div>
        </div>
        <submit-footer
          :disabled="form.hasErrors()"
          :title="$t('users.password.change').toString()"
        ></submit-footer>
      </form>
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent } from 'vue';

import { Error, SubmitFooter } from '@/components/forms';
import { createForm } from '@/util';

export default defineComponent({
  name: 'UserProfile',

  components: { Error, SubmitFooter },

  data() {
    return {
      form: createForm({
        password_current: null,
        password: null,
        password_confirmation: null,
      }),
    };
  },

  methods: {
    async submit() {
      await this.form.post('profile/password');
      await this.$router.push({ name: 'profile' });
      this.$toasted.success(this.$t(`users.password.changed`).toString());
    },
  },
});
</script>

<style lang="scss" scoped>
.container-center {
  width: 100%;
  display: flex;
  justify-content: center;
}

.component-center {
  width: 30rem;
}
</style>
