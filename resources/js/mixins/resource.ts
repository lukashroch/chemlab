import { defineComponent } from 'vue';

import type { Resource } from '@/router/resources';
import { resources } from '@/router/resources';

export default defineComponent({
  computed: {
    resource(): Resource {
      return resources.find((item) => item.name === this.module) as Resource;
    },
  },
});
