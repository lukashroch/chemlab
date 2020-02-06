import Error from '../../components/forms/Error';
import SubmitFooter from '../../components/forms/SubmitFooter';
import DetailMixin from './DetailMixin';

export default {
  name: 'Form',

  components: { Error, SubmitFooter },

  mixins: [DetailMixin],

  watch: {
    entry: {
      handler() {
        this.toForm(this.entry, this.isEdit ? 'edit' : 'create');
      },
      // For membership form load
      immediate: true
    }
  },

  computed: {
    isEdit() {
      return this.$route.name === `${this.module}.edit`;
    },
    isCreate() {
      return this.$route.name === `${this.module}.create`;
    }
  },

  methods: {
    toForm(data, status) {
      this.form.load(data, status);
    },

    async onSubmit() {
      if (this.isEdit) {
        const { data } = await this.form.put(`${this.module}/${this.id}`);
        this.toForm(data, 'edit');
        this.$toasted.success(this.$t(`common.msg.updated`, { name: data.name }));
      } else {
        const { data } = await this.form.post(this.module);
        this.$router.push({ name: `${this.module}.edit`, params: { id: data.id } });
        this.$toasted.success(this.$t(`common.msg.stored`, { name: data.name }));
      }
    }
  }
};
