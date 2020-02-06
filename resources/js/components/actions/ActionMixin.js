export default {
  props: {
    item: {
      type: Object,
      required: true
    },
    action: {
      type: String,
      required: true
    }
  },

  methods: {
    onClick() {
      this.$emit('action', this.action);
    }
  }
};
