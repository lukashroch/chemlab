<template>
  <label class="col-md-3 col-form-label fw-bold" :for="name">{{ $t(title) }}</label>
  <div class="col-md-9">
    <input
      :id="name"
      class="form-control"
      :name="name"
      :placeholder="$t(title)"
      type="text"
      :value="modelValue"
      @input="$emit('update:modelValue', $event.target.value)"
    />
    <error :msg="error"></error>
  </div>
</template>

<script lang="ts">
import { defineComponent } from 'vue';

import Error from './Error.vue';

export default defineComponent({
  name: 'FormInput',

  components: { Error },

  props: {
    modelValue: {
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

  emits: ['update:modelValue'],
});
</script>

<style lang="scss" scoped></style>
