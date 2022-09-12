import { defineComponent } from 'vue';

import { Error } from '@/components/forms';
import { createForm } from '@/util';

export default defineComponent({
  components: { Error },

  props: {
    appendParams: {
      type: Object,
      default() {
        return {};
      },
    },
    sortOrder: {
      type: Array,
      default() {
        return [];
      },
    },
    options: {
      type: Array,
      required: true,
    },
    selected: {
      type: Array,
      required: true,
    },
  },

  data() {
    return {
      form: createForm({
        items: this.selected,
      }),
    };
  },

  watch: {
    selected() {
      this.form.errors.clear('items');
      this.form.items = this.selected;
    },
  },
});
