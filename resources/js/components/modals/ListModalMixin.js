import Form from '../../utilities/Form';
import Error from '../forms/Error';

export default {
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

  components: { Error },

  data() {
    return {
      form: new Form({
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
};
