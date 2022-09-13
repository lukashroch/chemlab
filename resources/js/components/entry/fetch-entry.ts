import { mapActions } from 'pinia';
import { defineComponent } from 'vue';

import type { Dictionary } from '@/types';
import { useEntry } from '@/stores';

import hasEntry from './has-entry';

export default defineComponent({
  name: 'FetchMixin',

  mixins: [hasEntry],

  async beforeRouteUpdate(to, from, next) {
    if (from.params.id === to.params.id) {
      next();
      return;
    }

    await this.fetch();
    next();
  },

  async created() {
    await this.fetch();
  },

  methods: {
    ...mapActions(useEntry, ['request']),

    async fetch(query?: Dictionary) {
      const { path } = this.$route;
      await this.request({ path, query });
    },
  },
});
