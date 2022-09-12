import { defineComponent } from 'vue';
import { mapState } from 'vuex';

export default defineComponent({
  props: {
    id: {
      type: [Number, String],
      default: 'create',
    },
  },

  computed: {
    ...mapState({
      entry(state) {
        return state[this.module].entry.data;
      },
    }),
    entryLoaded() {
      return !!Object.keys(this.entry).length;
    },
  },
});
