import { mapActions, mapGetters } from 'vuex';

export default {
  computed: mapGetters('loading', ['isLoading']),

  methods: {
    ...mapActions('loading', {
      addLoading: 'add',
      removeLoading: 'remove',
      resetLoading: 'reset'
    }),

    async withLoading(promise, id = null) {
      const name = `${this.module}/${id ?? Math.round(Math.random() * 100)}`;
      this.addLoading(name);
      try {
        return await promise;
      } finally {
        this.removeLoading(name);
      }
    }
  }
};
