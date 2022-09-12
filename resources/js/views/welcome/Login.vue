<template>
  <div class="card welcome-card">
    <div class="card-header">
      <h1 v-t="'common.login'" class="text-center"></h1>
    </div>
    <div class="card-body p-4">
      <form @keydown="form.errors.clear()" @submit.prevent="onSubmit">
        <div class="form-group">
          <label v-t="'common.email'" for="name"></label>
          <input
            id="email"
            v-model="form.email"
            class="form-control"
            name="email"
            :placeholder="$t('common.email').toString()"
            type="text"
          />
          <error :msg="form.errors.get('email')"></error>
        </div>
        <div class="form-group">
          <label v-t="'passwords._'" for="password"></label>
          <input
            id="password"
            v-model="form.password"
            class="form-control"
            name="password"
            :placeholder="$t('passwords._').toString()"
            type="password"
          />
          <error :msg="form.errors.get('password')"></error>
        </div>
        <div class="form-group">
          <div class="px-2">
            <div class="custom-control custom-checkbox">
              <input
                id="remember"
                v-model="form.remember"
                class="custom-control-input"
                name="remember"
                type="checkbox"
              />
              <label v-t="'users.remember'" class="custom-control-label" for="remember"></label>
            </div>
          </div>
        </div>
        <div class="form-group">
          <button class="btn btn-lg btn-primary w-100" :disabled="form.hasErrors()" type="submit">
            {{ $t('common.login') }}
          </button>
        </div>
      </form>
    </div>
    <div class="card-footer">
      <div class="row justify-content-between">
        <div class="col-auto">
          <a class="btn-link" href="#" @click.prevent="$emit('passForgotten')">{{
            $t('passwords.forgot._')
          }}</a>
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
import { createForm } from '@/util';

export default defineComponent({
  name: 'Login',

  components: { Error },

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
    async onSubmit() {
      await this.form.post('login');
      await this.$router.push({ name: 'dashboard' });
    },
  },
});
</script>

<style lang="scss"></style>
