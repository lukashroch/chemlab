<template>
  <modal height="300px" :name="name" width="450px">
    <div class="modal-header">
      <h3 v-t="'passwords.forgot.title'" class="modal-title"></h3>
      <close :name="name"></close>
    </div>
    <div class="modal-body px-5 py-4">
      <form @keydown="form.errors.clear($event.target.name)" @submit.prevent="submit">
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
          <button class="btn btn-lg btn-primary w-100" :disabled="form.hasErrors()" type="submit">
            {{ $t('passwords.forgot.send') }}
          </button>
        </div>
      </form>
    </div>
  </modal>
</template>

<script lang="ts">
import { defineComponent } from 'vue';

import { Error } from '@/components/forms';
import { createForm } from '@/util';

import ModalMixin from './ModalMixin';

export default defineComponent({
  name: 'PasswordForgotten',

  components: { Error },

  mixins: [ModalMixin],

  data() {
    return {
      form: createForm({
        email: null,
      }),
    };
  },

  methods: {
    async submit() {
      await this.form.post('password/email');
      this.$toasted.success(this.$t('passwords.sent').toString());
      this.$modal.hide('password-forgotten');
    },
  },
});
</script>
