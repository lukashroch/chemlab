import { mapState } from 'pinia';
import { defineComponent } from 'vue';

import { useEntry } from '@/stores';

export default defineComponent({
  props: {
    id: {
      type: [Number, String],
      default: 'create',
    },
  },

  computed: {
    ...mapState(useEntry, {
      entry: 'data',
      entryLoaded: 'dataLoaded',
    }),
  },
});
