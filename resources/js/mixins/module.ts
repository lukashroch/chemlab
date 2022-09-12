import { defineComponent } from 'vue';
import { mapGetters } from 'vuex';

export default defineComponent({
  computed: mapGetters(['module']),
});
