<template>
  <div
    ref="toast"
    aria-atomic="true"
    aria-live="assertive"
    :class="`toast border-0 p-2 ${getTypeClass(item.type)}`"
    role="alert"
  >
    <div class="d-flex">
      <div class="toast-body">
        <span :class="`me-2 ${getIcon(item.type)}`"></span>
        {{ item.text }}
      </div>
      <button
        :aria-label="$t('common.close')"
        class="btn-close btn-close-white me-2 m-auto"
        data-bs-dismiss="toast"
        type="button"
      ></button>
    </div>
  </div>
</template>

<script lang="ts">
import type { PropType } from 'vue';
import Toast from 'bootstrap/js/dist/toast';
import { defineComponent, onBeforeUnmount, onMounted, ref } from 'vue';

import type { Message } from '@/stores';

export default defineComponent({
  name: 'Notification',

  props: {
    item: {
      type: Object as PropType<Message>,
      required: true,
    },
  },

  emits: ['close'],

  setup(props, { emit }) {
    const toast = ref<InstanceType<typeof HTMLFormElement>>();

    const getTypeClass = (type: string) => {
      switch (type) {
        case 'success':
          return 'text-bg-success';
        case 'info':
          return 'text-bg-primary';
        case 'error':
          return 'text-bg-danger';
        case 'warning':
          return 'text-bg-warning';
        default:
          return 'text-bg-primary';
      }
    };

    const getIcon = (type: string) => {
      switch (type) {
        case 'success':
        case 'info':
          return 'fas fa-circle-info';
        case 'error':
        case 'warning':
          return 'fas fa-circle-exclamation';
        default:
          return 'fas fa-circle-info';
      }
    };

    const close = () => {
      emit('close', props.item.id);
    };

    const toastHidden = () => {
      close();
    };

    onMounted(() => {
      window.addEventListener('hidden.bs.toast', toastHidden);

      if (toast.value) new Toast(toast.value, { delay: props.item.timeout }).show();
    });

    onBeforeUnmount(() => {
      window.removeEventListener('hidden.bs.toast', toastHidden);
    });

    return { getIcon, getTypeClass, toast };
  },
});
</script>

<style scoped></style>
