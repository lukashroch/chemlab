import { defineComponent } from 'vue';

export default defineComponent({
  props: {
    item: {
      type: Object,
      required: true,
    },
    action: {
      type: String,
      required: true,
    },
  },

  emits: ['action'],

  computed: {
    route() {
      return this.$route.name?.toString() ?? this.module;
    },
  },

  methods: {
    onClick() {
      this.$emit('action', this.action);
    },
  },
});
