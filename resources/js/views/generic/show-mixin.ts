import { defineComponent } from 'vue';

import hasEntry from './has-entry';
import hasRefs from './has-refs';

export default defineComponent({
  name: 'ShowMixin',

  mixins: [hasEntry, hasRefs],
});
