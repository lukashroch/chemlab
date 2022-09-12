<template>
  <vue-date-picker
    v-model="currentValue"
    :editable="false"
    :first-day-of-week="1"
    format="DD.MM.YYYY"
    input-class="form-control form-date"
    lang="cs"
    value-type="format"
    width="100%"
    @change="$emit('change', currentValue)"
    @input="$emit('input', currentValue)"
  >
  </vue-date-picker>
</template>

<script lang="ts">
import { defineComponent } from 'vue';
import VueDatePicker from 'vue2-datepicker';

export default defineComponent({
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
});
</script>

<style lang="scss" scoped></style>
