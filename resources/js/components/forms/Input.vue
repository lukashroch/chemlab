<template>
  <div>
    <label class="col-md-3 col-form-label fw6" :for="name">{{ $t(title) }}</label>
    <div class="col-md-9">
      <input
        :id="name"
        class="form-control"
        :name="name"
        :placeholder="$t(title).toString()"
        type="text"
        :value="value"
        @input="$emit('input', $event.target.value)"
      />
      <error :msg="error"></error>
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent } from 'vue';

import Error from './Error.vue';

export default defineComponent({
  name: 'FormInput',

  components: { Error },

  props: {
    value: {
      type: String,
      default: null,
    },
    title: {
      type: String,
      required: true,
    },
    name: {
      type: String,
      required: true,
    },
    error: {
      type: String,
      default: null,
    },
  },
});
</script>

<style lang="scss" scoped></style>
