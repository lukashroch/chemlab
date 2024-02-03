<template>
  <button class="btn btn-secondary" @click="open">
    <span class="fas fa-draw-polygon" :title="$t('chemicals.structure._')"></span>
  </button>
  <vue-final-modal
    v-model="dialog"
    class="d-flex justify-content-center align-items-center"
    content-class="bg-white rounded ketcher-dialog"
  >
    <div class="d-flex justify-content-between align-items-center px-4 py-2 border border-bottom">
      <h5 class="mb-0">{{ $t('chemicals.structure._') }}</h5>
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
    <div>
      <iframe
        id="ketcher"
        ref="ketcherRef"
        class="structure-sketcher"
        src="/vendor/ketcher/index.html"
      />
    </div>
    <div class="d-flex flex-row justify-content-end p-2">
      <button class="btn btn-outline-secondary me-1" type="button" @click.stop="close">
        <span class="fas fa-times" :title="$t('common.cancel')"></span>
        {{ $t('common.cancel') }}
      </button>
      <button class="btn btn-primary" type="button" @click="resolve">
        <span aria-hidden="true" class="fas fa-check-circle" />
        {{ $t('common.submit') }}
      </button>
    </div>
  </vue-final-modal>
</template>

<script lang="ts">
import type { Ketcher } from 'ketcher-core';
import { defineComponent, ref } from 'vue';
import { VueFinalModal } from 'vue-final-modal';
import { useI18n } from 'vue-i18n';

import { useMessages } from '@/stores';

export default defineComponent({
  name: 'Ketcher',

  components: { VueFinalModal },

  emits: ['inchikey'],

  setup(props, { emit }) {
    const { t } = useI18n();
    const dialog = ref(false);

    function close() {
      dialog.value = false;
    }

    function open() {
      dialog.value = true;
    }

    const ketcherRef = ref<InstanceType<typeof HTMLFormElement>>();
    const getKetcher = (): Ketcher | null => {
      return ketcherRef.value?.contentWindow.ketcher;
    };

    const resolve = async () => {
      try {
        const InChIKey = await getKetcher()?.getInChIKey();
        emit('inchikey', InChIKey);
        close();
      } catch (err) {
        useMessages().error(t('chemicals.structure.not.resolved'));
      }
    };

    return {
      close,
      dialog,
      open,
      ketcherRef,
      getKetcher,
      resolve,
    };
  },
});
</script>

<style>
.ketcher-dialog {
  width: 750px;
  height: auto;
  max-width: 750px;
  max-height: 80vh;
}
</style>
