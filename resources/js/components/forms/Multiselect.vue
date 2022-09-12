<template>
  <vue-multiselect
    v-model="selected"
    :clear-on-select="false"
    :close-on-select="false"
    deselect-label
    deselect-label-text
    :label="label"
    :multiple="true"
    :options="options"
    :placeholder="placeholder"
    :searchable="false"
    select-label
    selected-label
    :track-by="trackBy"
    @input="onInput"
  >
    <template #selection="{ values }">
      <span v-if="values.length" class="multiselect__single">
        {{ values.length === 1 ? values[0].name : `${values.length} vybrány` }}
      </span>
    </template>
    <template #option="{ option }">{{ option.name }}</template>
  </vue-multiselect>
</template>

<script lang="ts">
import { defineComponent } from 'vue';
import VueMultiselect from 'vue-multiselect';

export default defineComponent({
  name: 'Multiselect',

  components: { VueMultiselect },

  props: {
    trackBy: {
      type: String,
      default: 'id',
    },
    label: {
      type: String,
      default: 'name',
    },
    options: {
      type: Array,
      required: true,
    },
    placeholder: {
      type: String,
    },
    value: {
      type: Array,
      default() {
        return [];
      },
    },
  },

  data() {
    return {
      selected: this.onBind(this.value),
    };
  },

  watch: {
    value() {
      this.selected = this.onBind(this.value);
    },
  },

  methods: {
    onBind() {
      return this.options.filter((item) => this.value.includes(item[this.trackBy]));
    },

    onInput() {
      const input = this.selected.map((item) => item[this.trackBy]);
      this.$emit('input', input);
    },
  },
});
</script>

<style lang="scss" scoped></style>
