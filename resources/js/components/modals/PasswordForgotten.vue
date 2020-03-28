<template>
  <modal :name="name" width="450px" height="300px">
    <div class="modal-header">
      <h3 class="modal-title" v-t="'passwords.forgot.title'"></h3>
      <close :name="name"></close>
    </div>
    <div class="modal-body px-5 py-4">
      <form @submit.prevent="onSubmit" @keydown="form.errors.clear($event.target.name)">
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
          <button type="submit" class="btn btn-lg btn-primary w-100" :disabled="form.hasErrors()">
            {{ $t('passwords.forgot.send') }}
          </button>
        </div>
      </form>
    </div>
  </modal>
</template>

<script>
import ModalMixin from './ModalMixin';
import Error from '../forms/Error';
import Form from '../../utilities/Form';

export default {
  name: 'PasswordForgotten',

  components: { Error },

  mixins: [ModalMixin],

  data() {
    return {
      form: new Form({
        email: null,
      }),
    };
  },

  mounted() {},

  methods: {
    async onSubmit() {
      await this.form.post('password/email');
      this.$toasted.success(this.$t('passwords.sent'));
      this.$modal.hide('password-forgotten');
    },
  },
};
</script>
