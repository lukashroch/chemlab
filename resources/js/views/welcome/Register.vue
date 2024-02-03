<template>
  <div class="card welcome-card">
    <div class="card-header">
      <h1 v-t="'common.register'" class="text-center"></h1>
    </div>
    <div class="card-body p-4">
      <form @keydown="form.errors.clear($event.target.name)" @submit.prevent="submit">
        <div class="mb-3">
          <label v-t="'common.name'" for="name"></label>
          <input
            id="name"
            v-model="form.name"
            class="form-control"
            name="name"
            :placeholder="$t('common.name')"
            type="text"
          />
          <error :msg="form.errors.get('name')"></error>
        </div>
        <div class="mb-3">
          <label v-t="'common.email'" for="email"></label>
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
            autocomplete="new-password"
            class="form-control"
            name="password"
            :placeholder="$t('passwords._')"
            type="password"
          />
          <error :msg="form.errors.get('password')"></error>
        </div>
        <div class="mb-3">
          <label v-t="'passwords.confirmation'" for="password_confirmation"></label>
          <input
            id="password_confirmation"
            v-model="form.password_confirmation"
            autocomplete="new-password"
            class="form-control"
            name="password_confirmation"
            :placeholder="$t('passwords.confirmation')"
            type="password"
          />
          <error :msg="form.errors.get('password_confirmation')"></error>
        </div>
        <div class="form-group mt-4">
          <button class="btn btn-lg btn-primary w-100" :disabled="form.hasErrors()" type="submit">
            {{ $t('common.send') }}
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
          <a class="btn-link" href="#" @click.prevent="$emit('swap', 'login')">
            {{ $t('passwords.has_account') }}
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
  name: 'Register',

  components: { Error, PasswordForgotten },

  emits: ['swap'],

  data() {
    return {
      form: createForm({
        name: null,
        email: null,
        password: null,
        password_confirmation: null,
      }),
    };
  },

  methods: {
    async submit() {
      await this.form.post('register');
      await this.$router.push({ name: 'dashboard' });
    },
  },
});
</script>

<style lang="scss"></style>
