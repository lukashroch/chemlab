<template>
  <vue-multiselect
    v-model="selected"
    :options="options"
    :label="label"
    :track-by="trackBy"
    :placeholder="placeholder"
    :multiple="true"
    :searchable="false"
    :close-on-select="false"
    :clear-on-select="false"
    deselect-label
    deselect-label-text
    select-label
    selected-label
    @input="onInput"
  >
    <template v-slot:selection="{ values }">
      <span v-if="values.length" class="multiselect__single">
        {{ values.length === 1 ? values[0].name : `${values.length} vybrány` }}
      </span>
    </template>
    <template v-slot:option="{ option }">{{ option.name }}</template>
  </vue-multiselect>
</template>

<script>
import VueMultiselect from 'vue-multiselect';

export default {
  name: 'Multiselect',

  components: { VueMultiselect },

  props: {
    trackBy: {
      type: String,
      default: 'id'
    },
    label: {
      type: String,
      default: 'name'
    },
    options: {
      type: Array,
      required: true
    },
    placeholder: {
      type: String
    },
    value: {
      type: Array,
      default() {
        return [];
      }
    }
  },

  data() {
    return {
      selected: this.onBind(this.value)
    };
  },

  watch: {
    value() {
      this.selected = this.onBind(this.value);
    }
  },

  methods: {
    onBind() {
      return this.options.filter(item => this.value.includes(item[this.trackBy]));
    },

    onInput() {
      const input = this.selected.map(item => item[this.trackBy]);
      this.$emit('input', input);
    }
  }
};
</script>

<style scoped></style>
