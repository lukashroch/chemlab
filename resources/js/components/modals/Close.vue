<template>
  <button :aria-label="$t('common.close')" class="close" type="button" @click="$modal.hide(name)">
    <span :aria-label="$t('common.close')" class="fas fa-times"></span>
  </button>
</template>

<script>
export default {
  name: 'Close',

  props: {
    name: {
      type: String,
      required: true,
    },
  },
};
</script>

<style lang="scss" scoped></style>
