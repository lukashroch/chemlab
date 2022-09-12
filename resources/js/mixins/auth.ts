import { mapActions } from 'pinia';
import { defineComponent } from 'vue';

import { useUser } from '../stores';

export default defineComponent({
  methods: mapActions(useUser, ['can']),
});
