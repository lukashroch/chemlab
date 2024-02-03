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
    @update:model-value="update"
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
import type { PropType } from 'vue';
import { defineComponent, ref, watch } from 'vue';
import VueMultiselect from 'vue-multiselect';

import type { Dictionary } from '@/types';

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
      type: Array as PropType<Dictionary[]>,
      required: true,
    },
    placeholder: {
      type: String,
    },
    modelValue: {
      type: Array,
      default: () => [],
    },
  },

  emits: ['update:modelValue'],

  setup(props, { emit }) {
    const selected = ref(
      props.options.filter((item) => props.modelValue.includes(item[props.trackBy]))
    );

    watch(
      () => props.modelValue,
      (value) => {
        selected.value = props.options.filter((item) => value.includes(item[props.trackBy]));
      }
    );

    const update = () => {
      const input = selected.value.map((item) => item[props.trackBy]);
      emit('update:modelValue', input);
    };

    return {
      selected,
      update,
    };
  },
});
</script>

<style lang="scss" scoped></style>
