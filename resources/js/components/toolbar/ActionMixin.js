export default {
  props: {
    disabled: {
      type: Boolean,
      default: false,
    },
  },

  methods: {
    onClick() {
      this.$emit('action', this.$options._componentTag);
    },
  },
};
