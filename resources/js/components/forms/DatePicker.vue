<template>
  <vue-date-picker
    v-model="currentValue"
    :first-day-of-week="1"
    :editable="false"
    lang="cs"
    format="DD.MM.YYYY"
    value-type="format"
    input-class="form-control form-date"
    width="100%"
    @input="$emit('input', currentValue)"
    @change="$emit('change', currentValue)"
  >
  </vue-date-picker>
</template>

<script>
import VueDatePicker from 'vue2-datepicker';

export default {
  name: 'DatePicker',
  components: { VueDatePicker },

  props: {
    value: {
      type: String,
      default: null,
    },
  },

  data() {
    return {
      currentValue: this.value,
    };
  },

  watch: {
    value(val) {
      this.currentValue = val;
    },
  },
};
</script>

<style lang="scss" scoped></style>
