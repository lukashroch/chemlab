<template>
  <div class="scroll-top" :class="{ show: showTop }" @click.stop="toTop">
    <span class="fas fa-2x fa-fw fa-angle-up" :title="$t('common.top')"></span>
  </div>
</template>

<script>
import throttle from 'lodash/throttle';

export default {
  name: 'ScrollTop',

  props: {
    topEl: {
      type: String,
      default: '#top',
    },
  },

  data() {
    return {
      y: 0,
    };
  },

  computed: {
    showTop() {
      return this.y > 150;
    },
  },

  created() {
    window.addEventListener('scroll', this.handleScroll);
  },

  destroyed() {
    window.removeEventListener('scroll', this.handleScroll);
  },

  methods: {
    handleScroll: throttle(function () {
      this.y = window.scrollY;
    }, 250),

    toTop() {
      this.$scrollTo(this.topEl, 500);
    },
  },
};
</script>

<style lang="scss"></style>
