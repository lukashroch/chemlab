import { mapActions, mapGetters } from 'vuex';

export default {
  computed: mapGetters('loading', { isLoading: 'isLoading' }),

  methods: mapActions('loading', {
    addLoading: 'add',
    removeLoading: 'remove',
    resetLoading: 'reset'
  })
};
