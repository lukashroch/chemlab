import { defineComponent } from 'vue';

import fetchEntry from './fetch-entry';
import hasRefs from './has-refs';
import Layout from './layout.vue';

export default defineComponent({
  name: 'ShowMixin',

  components: { Layout },

  mixins: [fetchEntry, hasRefs],
});
