import { mapState } from 'pinia';
import { defineComponent } from 'vue';

import { useUser } from '@/stores';

export default defineComponent({
  props: {
    breakPoint: {
      type: Number,
      default: 768,
    },
  },

  data() {
    return {
      sidebar: true,
    };
  },

  computed: {
    ...mapState(useUser, ['loaded']),
    showSidebar() {
      return this.sidebar && this.loaded;
    },
  },

  async created() {
    this.toggleIfCan();
  },

  methods: {
    getWidth() {
      return window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth;
    },

    toggleIfCan() {
      if (this.getWidth() <= this.breakPoint) this.toggleSidebar();
    },

    toggleSidebar() {
      this.sidebar = !this.sidebar;
      if (this.getWidth() <= this.breakPoint) {
        if (this.sidebar) document.body.classList.add('overflow-hidden');
        else document.body.classList.remove('overflow-hidden');
      }
    },
  },
});
