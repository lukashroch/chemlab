<template>
  <div class="toast-container p-3">
    <notification
      v-for="item in messages.items"
      :key="item.id"
      :item="item"
      @close="remove"
    ></notification>
  </div>
</template>

<script lang="ts">
import type { PropType } from 'vue';
import { defineComponent } from 'vue';

import { useMessages } from '@/stores';

import Notification from './Notification.vue';

export default defineComponent({
  name: 'Notifications',

  components: { Notification },

  props: {
    items: {
      type: Object as PropType<Record<'success' | 'info' | 'warning' | 'error', string[]>>,
      default: () => ({}),
    },
  },

  setup(props) {
    const messages = useMessages();

    Object.entries(props.items).forEach(([type, items]) => {
      items.forEach((message) => {
        messages.add(type, message);
      });
    });

    const remove = (id: string) => {
      messages.remove(id);
    };

    return { messages, remove };
  },
});
</script>

<style scoped>
.toast-container {
  position: fixed;
  bottom: 0;
  left: 50%;

  transform: translate(-50%, 0);
}
</style>
