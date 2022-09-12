import { defineComponent } from 'vue';
import { mapState } from 'vuex';

export default defineComponent({
  computed: {
    ...mapState({
      refs(state) {
        return state[this.module].entry.refs;
      },
    }),
    refsLoaded() {
      return !!Object.keys(this.refs).length;
    },
  },
});
