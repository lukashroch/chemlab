<template>
  <div class="welcome-page">
    <div class="card welcome-card">
      <div class="card-header">
        <h1 class="my-2">{{ $t('passwords.forgot.title') }}</h1>
      </div>
      <div class="card-body p-4">
        <form @keydown="form.errors.clear($event.target.name)" @submit.prevent="onSubmit">
          <div class="form-group form-row">
            <label class="col-form-label" for="name">{{ $t('common.email') }}</label>
            <input
              id="email"
              v-model="form.email"
              class="form-control"
              name="email"
              :placeholder="$t('common.email')"
              type="text"
            />
            <error :msg="form.errors.get('email')"></error>
          </div>
          <div class="form-group form-row">
            <label class="col-form-label" for="password_confirm">{{ $t('passwords._') }}</label>
            <input
              id="password"
              v-model="form.password"
              class="form-control"
              name="password"
              :placeholder="$t('passwords._')"
              type="password"
            />
            <error :msg="form.errors.get('password')"></error>
          </div>
          <div class="form-group form-row">
            <label class="col-form-label" for="password_confirmation">{{
              $t('passwords.confirmation')
            }}</label>
            <input
              id="password_confirmation"
              v-model="form.password_confirmation"
              class="form-control"
              name="password_confirmation"
              :placeholder="$t('passwords.confirmation')"
              type="password"
            />
            <error :msg="form.errors.get('password_confirmation')"></error>
          </div>
          <div class="form-group form-row justify-content-center">
            <div class="col-auto">
              <button
                class="btn btn-lg btn-primary px-5"
                :disabled="form.hasErrors()"
                type="submit"
              >
                {{ $t('common.send') }}
              </button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
import Error from '@/components/forms/Error.vue';
import Form from '@/utilities/Form';

export default {
  name: 'PasswordReset',

  components: { Error },

  data() {
    return {
      form: new Form({
        token: this.$route.params.token,
        email: this.$route.query.email,
        password: null,
        password_confirmation: null,
      }),
    };
  },

  methods: {
    async onSubmit() {
      await this.form.post('password/reset');
      this.$toasted.success(this.$t('passwords.reset'));
      this.$router.push({ name: 'dashboard' });
    },
  },
};
</script>

<style lang="scss"></style>
