import { defineComponent } from 'vue';

import type { Dictionary } from '@/types';
import { Error, SubmitFooter } from '@/components/forms';
import { createForm } from '@/util';

import hasEntry from './has-entry';
import mapRefs from './has-refs';

export default defineComponent({
  name: 'FormMixin',

  components: { Error, SubmitFooter },

  mixins: [hasEntry, mapRefs],

  data() {
    return {
      form: createForm({}),
    };
  },

  computed: {
    isEdit() {
      return this.$route.name === `${this.module}.edit`;
    },
    isCreate() {
      return this.$route.name === `${this.module}.create`;
    },
  },

  watch: {
    entry: {
      handler() {
        this.toForm(this.entry);
      },
      immediate: true,
    },
  },

  methods: {
    toForm(data: Dictionary) {
      this.form.load(data);
    },

    async onSubmit() {
      if (this.isEdit) {
        const { data } = await this.form.put(`${this.module}/${this.id}`);
        this.toForm(data);
        this.$toasted.success(this.$t(`common.msg.updated`, { name: data.name }).toString());
      } else {
        const { data } = await this.form.post(this.module);
        await this.$router.push({ name: `${this.module}.edit`, params: { id: data.id } });
        this.$toasted.success(this.$t(`common.msg.stored`, { name: data.name }).toString());
      }
    },
  },
});
