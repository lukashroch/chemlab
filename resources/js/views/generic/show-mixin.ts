import { defineComponent } from 'vue';

import hasEntry from './has-entry';
import mapRefs from './has-refs';

export default defineComponent({
  name: 'ShowMixin',

  mixins: [hasEntry, mapRefs],
});
