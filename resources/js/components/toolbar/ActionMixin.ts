import { defineComponent } from 'vue';

export default defineComponent({
  props: {
    action: {
      type: String,
      default: undefined,
    },
    disabled: {
      type: Boolean,
      default: false,
    },
  },

  emits: ['action'],

  methods: {
    onClick() {
      this.$emit('action', this.action);
    },
  },
});
