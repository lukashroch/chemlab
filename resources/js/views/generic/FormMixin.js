import Error from '../../components/forms/Error';
import SubmitFooter from '../../components/forms/SubmitFooter';
import hasEntry from './hasEntry';
import mapEntry from './mapEntry';
import mapRefs from './mapRefs';

export default {
  name: 'Form',

  components: { Error, SubmitFooter },

  mixins: [hasEntry, mapEntry, mapRefs],

  watch: {
    entry: {
      handler() {
        this.toForm(this.entry);
      },
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
    toForm(data) {
      this.form.load(data);
    },

    async onSubmit() {
      if (this.isEdit) {
        const { data } = await this.form.put(`${this.module}/${this.id}`);
        this.toForm(data);
        this.$toasted.success(this.$t(`common.msg.updated`, { name: data.name }));
      } else {
        const { data } = await this.form.post(this.module);
        this.$router.push({ name: `${this.module}.edit`, params: { id: data.id } });
        this.$toasted.success(this.$t(`common.msg.stored`, { name: data.name }));
      }
    }
  }
};
