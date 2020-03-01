<template>
  <modal name="password-forgotten" width="500px" height="300px">
    <div class="modal-header">
      <h3 class="modal-title">
        {{ $t('passwords.forgot.title') }}
      </h3>
      <close name="password-forgotten"></close>
    </div>
    <div class="modal-body px-5 py-4">
      <form @submit.prevent="onSubmit" @keydown="form.errors.clear($event.target.name)">
        <div class="form-group form-row">
          <label for="name" class="col-form-label">{{ $t('common.email') }}</label>
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
        <div class="form-group form-row justify-content-center">
          <div class="col-auto">
            <button type="submit" class="btn btn-lg btn-primary px-5" :disabled="form.hasErrors()">
              {{ $t('passwords.forgot.send') }}
            </button>
          </div>
        </div>
      </form>
    </div>
  </modal>
</template>

<script>
import Close from './Close';
import Error from '../forms/Error';
import Form from '../../utilities/Form';

export default {
  name: 'PasswordForgotten',

  components: { Close, Error },

  data() {
    return {
      form: new Form({
        email: null
      })
    };
  },

  mounted() {},

  methods: {
    async onSubmit() {
      await this.form.post('password/email');
      this.$toasted.success(this.$t('passwords.sent'));
      this.$modal.hide('password-forgotten');
    }
  }
};
</script>
