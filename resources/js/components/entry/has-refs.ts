import { mapState } from 'pinia';
import { defineComponent } from 'vue';

import { useEntry } from '@/stores';

export default defineComponent({
  computed: mapState(useEntry, ['refs', 'refsLoaded']),
});
