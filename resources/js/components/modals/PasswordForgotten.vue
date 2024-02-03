<template>
  <a class="btn-link" href="#" @click="open">{{ $t('passwords.forgot._') }}</a>
  <vue-final-modal
    v-model="dialog"
    class="d-flex justify-content-center align-items-center"
    content-class="bg-white rounded password-forgotten-dialog"
  >
    <div class="d-flex justify-content-between align-items-center px-4 py-2 border border-bottom">
      <h5 class="mb-0">{{ $t('passwords.forgot.title') }}</h5>
      <button
        :aria-label="$t('common.close')"
        class="btn"
        :title="$t('common.close')"
        type="button"
        @click="close"
      >
        <span :aria-label="$t('common.close')" class="fas fa-lg fa-times"></span>
      </button>
    </div>
    <div class="p-4">
      <form @keydown="form.errors.clear($event.target.name)" @submit.prevent="submit">
        <div class="mb-3">
          <label v-t="'common.email'" for="name"></label>
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
        <div class="mb-3">
          <button class="btn btn-lg btn-primary w-100" :disabled="form.hasErrors()" type="submit">
            {{ $t('passwords.forgot.send') }}
          </button>
        </div>
      </form>
    </div>
  </vue-final-modal>
</template>

<script lang="ts">
import { defineComponent, reactive, ref } from 'vue';
import { VueFinalModal } from 'vue-final-modal';
import { useI18n } from 'vue-i18n';

import { Error } from '@/components/forms';
import { useMessages } from '@/stores';
import { createForm } from '@/util';

export default defineComponent({
  name: 'PasswordForgotten',

  components: { Error, VueFinalModal },

  setup() {
    const { t } = useI18n();

    const dialog = ref(false);
    const form = reactive(createForm({ email: null }));

    function close() {
      dialog.value = false;
    }

    function open() {
      dialog.value = true;
    }

    async function submit() {
      await form.post('password/email');
      useMessages().success(t('passwords.sent'));
      close();
    }

    return {
      dialog,
      form,
      close,
      open,
      submit,
    };
  },
});
</script>

<style lang="scss">
.password-forgotten-dialog {
  height: 300px;
  width: 450px;
  max-width: 700px;
  max-height: 80vh;
}
</style>
