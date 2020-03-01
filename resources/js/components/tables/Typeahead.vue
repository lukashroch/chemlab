<template>
  <div class="input-group typeahead">
    <input
      ref="input"
      :value="value"
      type="text"
      class="form-control"
      :placeholder="$t('common.search.title')"
      @input="$emit('input', $event.target.value)"
      @focus="addFocus('input')"
      @blur="removeFocus('input')"
      @keyup.enter="$emit('submit')"
    />
    <div
      class="results"
      :class="{ active: opened }"
      tabindex="0"
      @focus="addFocus('results')"
      @blur="removeFocus('results')"
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

<script>
import debounce from 'lodash/debounce';
import escapeRegExp from 'lodash/escapeRegExp';
import { mapState } from 'vuex';

export default {
  name: 'Typeahead',

  props: {
    value: {
      type: String,
      default: null
    },
    delay: {
      type: Number,
      default: 500
    },
    minLength: {
      type: Number,
      default: 3
    },
    maxResults: {
      type: Number,
      default: 5
    }
  },

  data() {
    return {
      focus: [],
      results: []
    };
  },

  computed: {
    ...mapState({
      refs(state) {
        return state[this.module].refs?.typeahead ?? [];
      }
    }),
    focused() {
      return !!this.focus.length;
    },
    opened() {
      return this.focused && this.results.length;
    }
  },

  watch: {
    value() {
      this.debouncedFetch();
    }
  },

  created() {
    this.debouncedFetch = debounce(this.fetch, this.delay);
  },

  methods: {
    addFocus(item) {
      this.focus.push(item);
    },

    removeFocus(item) {
      this.focus = this.focus.filter(i => i !== item);
    },

    fetch() {
      if (!this.value || this.value.length < this.minLength) {
        this.clear();
        return;
      }

      const results = this.refs.filter(
        item => item.toLowerCase().search(escapeRegExp(this.value.toLowerCase())) !== -1
      );

      this.results = results.slice(0, this.maxResults);
    },

    select(value) {
      this.update(value);
      this.$refs.input.focus();
      this.clear();
    },

    update(value) {
      this.$emit('input', value);
    },

    clear() {
      this.results = [];
    },

    highlight(value) {
      if (!value) return '';

      return value.replace(
        new RegExp(`(${escapeRegExp(this.value)})`, 'ig'),
        `<strong>$1</strong>`
      );
    }
  }
};
</script>
