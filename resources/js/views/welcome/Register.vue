<template>
  <div class="card welcome-card">
    <div class="card-header">
      <h1 class="text-center">
        {{ $t('common.register') }}
      </h1>
    </div>
    <div class="card-body p-4">
      <form @submit.prevent="onSubmit" @keydown="form.errors.clear($event.target.name)">
        <div class="form-group form-row">
          <label for="name" class="col-form-label">{{ $t('common.name') }}</label>
          <input
            id="name"
            v-model="form.name"
            type="text"
            name="name"
            class="form-control"
            :placeholder="$t('common.name')"
          />
          <error :msg="form.errors.get('name')"></error>
        </div>
        <div class="form-group form-row">
          <label for="email" class="col-form-label">{{ $t('common.email') }}</label>
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
        <div class="form-group form-row">
          <label for="password" class="col-form-label">{{ $t('passwords._') }}</label>
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
        <div class="form-group form-row">
          <label for="password_confirmation" class="col-form-label">{{
            $t('passwords.confirmation')
          }}</label>
          <input
            id="password_confirmation"
            v-model="form.password_confirmation"
            type="password"
            name="password_confirmation"
            class="form-control"
            :placeholder="$t('passwords.confirmation')"
          />
          <error :msg="form.errors.get('password_confirmation')"></error>
        </div>
        <div class="form-group row justify-content-center">
          <div class="col-auto">
            <button type="submit" class="btn btn-lg btn-primary px-5" :disabled="form.hasErrors()">
              {{ $t('common.send') }}
            </button>
          </div>
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
          <a class="btn-link" href="#" @click.prevent="$emit('swap', 'login')">
            {{ $t('passwords.has_account') }}
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
  name: 'Register',

  components: { Error },

  data() {
    return {
      form: new Form({
        name: null,
        email: null,
        password: null,
        password_confirmation: null
      })
    };
  },

  methods: {
    async onSubmit() {
      await this.form.post('register');
      this.$router.push({ name: 'dashboard' });
    }
  }
};
</script>

<style lang="scss"></style>
