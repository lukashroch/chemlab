<template>
  <button type="button" class="close" :aria-label="$t('common.close')" @click="$modal.hide(name)">
    <span class="fas fa-times" :aria-label="$t('common.close')"></span>
  </button>
</template>

<script>
export default {
  name: 'Close',

  props: {
    name: {
      type: String,
      required: true
    }
  }
};
</script>

<style scoped></style>
