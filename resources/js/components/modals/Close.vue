<template>
  <button :aria-label="$t('common.close')" class="close" type="button" @click="$modal.hide(name)">
    <span :aria-label="$t('common.close')" class="fas fa-times"></span>
  </button>
</template>

<script lang="ts">
import { defineComponent } from 'vue';

export default defineComponent({
  name: 'Close',

  props: {
    name: {
      type: String,
      required: true,
    },
  },
});
</script>

<style lang="scss" scoped></style>
