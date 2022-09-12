import { defineComponent } from 'vue';

import Close from './Close.vue';

export default defineComponent({
  components: { Close },

  props: {
    name: {
      type: String,
      required: true,
    },
  },

  methods: {
    close() {
      this.$modal.hide(this.name);
    },
  },
});
