<template>
  <div>
    <label :for="name" class="col-md-3 col-form-label fw6">{{ $t(title) }}</label>
    <div class="col-md-9">
      <input
        :id="name"
        type="text"
        :name="name"
        class="form-control"
        :placeholder="$t(title)"
        :value="value"
        @input="$emit('input', $event.target.value)"
      />
      <error :msg="error"></error>
    </div>
  </div>
</template>

<script>
import Error from './Error';

export default {
  name: 'Input',

  components: { Error },

  props: {
    value: {
      type: String,
      default: null
    },
    title: {
      type: String,
      required: true
    },
    name: {
      type: String,
      required: true
    },
    error: {
      type: String,
      default: null
    }
  }
};
</script>

<style scoped></style>
