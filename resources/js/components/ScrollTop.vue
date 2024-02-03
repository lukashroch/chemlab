<template>
  <div class="scroll-top" :class="{ show: showTop }" @click.stop="toTop">
    <span class="fas fa-2x fa-angle-up" :title="$t('common.top')"></span>
  </div>
</template>

<script lang="ts">
import throttle from 'lodash/throttle';
import { computed, defineComponent, onBeforeMount, onBeforeUnmount, ref } from 'vue';

export default defineComponent({
  name: 'ScrollTop',

  props: {
    topEl: {
      type: String,
      default: '#top',
    },
  },

  setup() {
    const y = ref(0);

    const showTop = computed(() => y.value > 150);

    const handleScroll = throttle(() => {
      y.value = window.scrollY;
    }, 250);

    onBeforeMount(() => {
      window.addEventListener('scroll', handleScroll);
    });

    onBeforeUnmount(() => {
      window.removeEventListener('scroll', handleScroll);
    });

    return { showTop };
  },

  methods: {
    toTop() {
      this.$scrollTo(this.topEl, 500);
    },
  },
});
</script>

<style lang="scss"></style>
