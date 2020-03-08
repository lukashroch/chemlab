import { mapState } from 'vuex';

export default {
  computed: {
    ...mapState({
      refs(state) {
        return state[this.module].entry.refs;
      }
    }),
    refsLoaded() {
      return !!Object.keys(this.refs).length;
    }
  }
};
