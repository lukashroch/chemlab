<template>
  <div class="tab-pane active" role="tabpanel" v-if="isLoaded">
    <table class="table table-hover"></table>
  </div>
</template>

<script>
import ShowMixin from '../generic/ShowMixin';

export default {
  name: 'Items',

  mixins: [ShowMixin],

  computed: {
    items() {
      return this.entry?.items ?? [];
    }
  }
};
</script>

<style scoped></style>
