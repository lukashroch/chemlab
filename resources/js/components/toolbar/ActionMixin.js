export default {
  props: {
    selected: {
      type: Array,
      default() {
        return [];
      }
    },
    disabled: {
      type: Boolean,
      default: false
    }
  },

  methods: {
    onClick() {
      this.$emit('action', this.$options._componentTag);
    }
  }
};
