<template>
  <div class="input-group typeahead">
    <input
      ref="input"
      class="form-control"
      :placeholder="$t('common.search._')"
      type="text"
      :value="modelValue"
      @blur="removeFocus('input')"
      @focus="addFocus('input')"
      @input="update($event.target.value)"
      @keyup.enter="$emit('submit')"
    />
    <div
      class="results"
      :class="{ active: opened }"
      tabindex="0"
      @blur="removeFocus('results')"
      @focus="addFocus('results')"
    >
      <ul class="results-list">
        <li
          v-for="item in results"
          :key="item"
          class="results-list-item"
          @click="select(item)"
          v-html="highlight(item)"
        ></li>
      </ul>
    </div>
  </div>
</template>

<script lang="ts">
import { watchDebounced } from '@vueuse/core';
import escapeRegExp from 'lodash/escapeRegExp';
import { computed, defineComponent, ref } from 'vue';

import { useResource } from '@/stores';

export default defineComponent({
  name: 'Typeahead',

  props: {
    modelValue: {
      type: String,
      default: null,
    },
    delay: {
      type: Number,
      default: 500,
    },
    minLength: {
      type: Number,
      default: 3,
    },
    maxResults: {
      type: Number,
      default: 5,
    },
  },

  emits: ['update:modelValue', 'submit'],

  setup(props, { emit }) {
    const input = ref<InstanceType<typeof HTMLFormElement>>();
    const resource = useResource();
    const focus = ref<string[]>([]);
    const results = ref<string[]>([]);

    const typeaheadRefs = computed<string[]>(() => resource.refs?.typeahead ?? []);
    const focused = computed(() => focus.value.length);
    const opened = computed(() => focused.value && results.value.length);

    function clear() {
      results.value = [];
    }

    function select(value: string) {
      update(value);
      input.value?.focus();
      clear();
    }

    function update(value: string) {
      emit('update:modelValue', value);
    }

    function fetch() {
      if (!props.modelValue || props.modelValue.length < props.minLength) {
        clear();
        return;
      }

      const items = typeaheadRefs.value.filter(
        (item) => item.toLowerCase().search(escapeRegExp(props.modelValue.toLowerCase())) !== -1
      );

      results.value = items.slice(0, props.maxResults);
    }

    function addFocus(item: string) {
      focus.value.push(item);
    }

    function removeFocus(item: string) {
      focus.value = focus.value.filter((i) => i !== item);
    }

    function highlight(value: string) {
      if (!value) return '';

      return value.replace(
        new RegExp(`(${escapeRegExp(props.modelValue)})`, 'ig'),
        `<strong>$1</strong>`
      );
    }

    watchDebounced(
      () => props.modelValue,
      () => {
        fetch();
      },
      { debounce: props.delay, maxWait: 2000 }
    );

    return {
      focus,
      addFocus,
      removeFocus,
      input,
      results,
      highlight,
      fetch,
      opened,
      select,
      update,
    };
  },
});
</script>
