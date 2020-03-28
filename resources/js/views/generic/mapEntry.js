import { mapState } from 'vuex';

export default {
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
};
