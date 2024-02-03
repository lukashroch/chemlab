<template>
  <button class="btn btn-primary me-1" @click="open">
    <span class="fas fa-exchange-alt"></span>
    {{ $t('common.move') }}
  </button>
  <vue-final-modal
    v-model="dialog"
    class="d-flex justify-content-center align-items-center"
    content-class="bg-white rounded chemical-move-dialog"
  >
    <div class="d-flex justify-content-between align-items-center px-4 py-2 border border-bottom">
      <h5 class="mb-0">{{ $t('chemicals.items.move') }}</h5>
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
      <form @submit.prevent="submit">
        <div class="modal-body">
          <div class="row mb-3 justify-content-center">
            <div class="col-8 p-3 border-bottom">
              {{ $t('common.records.selected') }}:
              <span class="border rounded mx-3 px-3 p-2">{{
                form.items.length ? form.items.length : $t('common.none')
              }}</span>
              <error :msg="form.errors.get('items')"></error>
            </div>
          </div>
          <div class="row mb-3 justify-content-center">
            <div class="col-8">
              <label for="store_id">{{ $t('stores.title') }}</label>
              <select
                id="store_id"
                v-model="form.store_id"
                class="form-select"
                name="store_id"
                @change="form.errors.clear('store_id')"
              >
                <option v-for="option in options" :key="option.id" :value="option.id">
                  {{ option.name }}
                </option>
              </select>
              <error :msg="form.errors.get('store_id')"></error>
            </div>
          </div>
        </div>
        <div class="d-flex justify-content-end">
          <button class="btn btn-secondary me-1" type="button" @click.stop="close">
            <span class="fas fa-times me-1" :title="$t('common.cancel')"></span>
            {{ $t('common.cancel') }}
          </button>
          <button class="btn btn-primary" :disabled="form.hasErrors()" type="submit">
            <span class="fas fa-save me-1" :title="$t('common.save')"></span>
            {{ $t('common.save') }}
          </button>
        </div>
      </form>
    </div>
  </vue-final-modal>
</template>

<script lang="ts">
import type { PropType } from 'vue';
import { defineComponent, reactive, ref } from 'vue';
import { VueFinalModal } from 'vue-final-modal';
import { useI18n } from 'vue-i18n';

import { Error } from '@/components/forms';
import { type Option, useMessages } from '@/stores';
import { createForm } from '@/util';

export default defineComponent({
  name: 'ChemicalMove',

  components: { Error, VueFinalModal },

  props: {
    options: {
      type: Array as PropType<Option[]>,
      default: () => [],
    },
    selected: {
      type: Array as PropType<number[]>,
      required: true,
    },
  },

  emits: ['refresh'],

  setup(props, { emit }) {
    const { t } = useI18n();

    const dialog = ref(false);
    const form = reactive(
      createForm({
        store_id: null,
        items: props.selected,
      })
    );

    function close() {
      dialog.value = false;
    }

    function open() {
      dialog.value = true;
    }

    async function submit() {
      await form.post(`chemical-items/move`);
      useMessages().success(t('common.msg.multi.moved'));
      emit('refresh');
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
.chemical-move-dialog {
  max-width: 700px;
  max-height: 80vh;
}
</style>
