import Close from './Close.vue';

export default {
  props: {
    name: {
      type: String,
      required: true,
    },
  },

  components: { Close },

  methods: {
    close() {
      this.$modal.hide(this.name);
    },
  },
};
