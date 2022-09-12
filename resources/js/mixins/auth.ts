import { defineComponent } from 'vue';
import { mapGetters } from 'vuex';

export default defineComponent({
  computed: mapGetters({ can: 'user/can' }),
});
