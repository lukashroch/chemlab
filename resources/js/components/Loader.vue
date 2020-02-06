<template>
  <div class="loading" :class="{ show: show }">
    <img src="/images/spinner.svg" alt="spinner" />
  </div>
</template>

<script>
export default {
  name: 'Loader',

  props: {
    show: {
      type: Boolean,
      default: false
    }
  }
};
</script>

<style scoped></style>
