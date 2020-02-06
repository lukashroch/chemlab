import { mapState } from 'vuex';

export default {
  props: {
    id: {
      type: [Number, String],
      default: 'create'
    }
  },

  computed: {
    ...mapState({
      entry(state) {
        return state[this.module].entry.data;
      },
      refs(state) {
        return state[this.module].entry.refs;
      }
    }),
    isLoaded() {
      return !!Object.keys(this.entry).length;
    }
  }
};
