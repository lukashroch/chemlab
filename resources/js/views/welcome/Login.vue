<template>
  <div class="card welcome-card">
    <div class="card-header">
      <h1 class="text-center" v-t="'common.login'"></h1>
    </div>
    <div class="card-body p-4">
      <form @submit.prevent="onSubmit" @keydown="form.errors.clear()">
        <div class="form-group">
          <label for="name" v-t="'common.email'"></label>
          <input
            id="email"
            v-model="form.email"
            type="text"
            name="email"
            class="form-control"
            :placeholder="$t('common.email')"
          />
          <error :msg="form.errors.get('email')"></error>
        </div>
        <div class="form-group">
          <label for="password" v-t="'passwords._'"></label>
          <input
            id="password"
            v-model="form.password"
            type="password"
            name="password"
            class="form-control"
            :placeholder="$t('passwords._')"
          />
          <error :msg="form.errors.get('password')"></error>
        </div>
        <div class="form-group">
          <div class="px-2">
            <div class="custom-control custom-checkbox">
              <input
                type="checkbox"
                class="custom-control-input"
                id="remember"
                name="remember"
                v-model="form.remember"
              />
              <label class="custom-control-label" for="remember" v-t="'users.remember'"></label>
            </div>
          </div>
        </div>
        <div class="form-group">
          <button type="submit" class="btn btn-lg btn-primary w-100" :disabled="form.hasErrors()">
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

<script>
import Error from '../../components/forms/Error';
import Form from '../../utilities/Form';

export default {
  name: 'Login',

  components: { Error },

  data() {
    return {
      form: new Form({
        email: null,
        password: null,
        remember: false,
      }),
    };
  },

  methods: {
    async onSubmit() {
      await this.form.post('login');
      this.$router.push({ name: 'dashboard' });
    },
  },
};
</script>

<style lang="scss"></style>
