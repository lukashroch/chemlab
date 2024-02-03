<template>
  <div class="card welcome-card">
    <div class="card-header">
      <h1 v-t="'common.login'" class="text-center"></h1>
    </div>
    <div class="card-body p-4">
      <form @keydown="form.errors.clear()" @submit.prevent="submit">
        <div class="mb-3">
          <label v-t="'common.email'" for="name"></label>
          <input
            id="email"
            v-model="form.email"
            autocomplete="email"
            class="form-control"
            name="email"
            :placeholder="$t('common.email')"
            type="text"
          />
          <error :msg="form.errors.get('email')"></error>
        </div>
        <div class="mb-3">
          <label v-t="'passwords._'" for="password"></label>
          <input
            id="password"
            v-model="form.password"
            autocomplete="current-password"
            class="form-control"
            name="password"
            :placeholder="$t('passwords._')"
            type="password"
          />
          <error :msg="form.errors.get('password')"></error>
        </div>
        <div class="mb-3">
          <div class="px-2">
            <div class="form-check">
              <input
                id="remember"
                v-model="form.remember"
                class="form-check-input"
                name="remember"
                type="checkbox"
              />
              <label v-t="'users.remember'" class="form-check-label" for="remember"></label>
            </div>
          </div>
        </div>
        <div class="mb-3">
          <button class="btn btn-lg btn-primary w-100" :disabled="form.hasErrors()" type="submit">
            {{ $t('common.login') }}
          </button>
        </div>
      </form>
    </div>
    <div class="card-footer">
      <div class="row justify-content-between">
        <div class="col-auto">
          <password-forgotten></password-forgotten>
        </div>
        <div class="col-auto">
          <a class="btn-link" href="#" @click.prevent="$emit('swap', 'register')">
            {{ $t('passwords.no_account') }}
          </a>
        </div>
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent } from 'vue';

import { Error } from '@/components/forms';
import { PasswordForgotten } from '@/components/modals';
import { createForm } from '@/util';

export default defineComponent({
  name: 'Login',

  components: { Error, PasswordForgotten },

  emits: ['swap'],

  data() {
    return {
      form: createForm({
        email: null,
        password: null,
        remember: false,
      }),
    };
  },

  methods: {
    async submit() {
      await this.form.post('login');
      await this.$router.push({ name: 'dashboard' });
    },
  },
});
</script>

<style lang="scss"></style>
