<template>
  <li class="nav-item">
    <div class="nav-link d-flex align-items-center nav-header" @click="toggle = !toggle">
      <span :class="`fas ${group.icon} me-1`"></span>
      <span class="flex-fill">{{ $t(`common.${group.name}`) }}</span>
      <span class="fas fa-angle-down" :class="{ 'fa-rotate-90': !toggle }"></span>
    </div>
    <Vue3SlideUpDown :model-value="toggle" tag="div">
      <ul class="nav nav-pills flex-column">
        <menu-item v-for="item in items" :key="item.name" :item="item"></menu-item>
      </ul>
    </Vue3SlideUpDown>
  </li>
</template>

<script lang="ts">
import type { PropType } from 'vue';
import { defineComponent } from 'vue';
import { Vue3SlideUpDown } from 'vue3-slide-up-down';

import type { ResourceGroup } from '@/router/resources';

import MenuItem from './MenuItem.vue';

export default defineComponent({
  name: 'MenuTree',

  components: { MenuItem, Vue3SlideUpDown },

  props: {
    group: {
      type: Object as PropType<ResourceGroup>,
      required: true,
    },
    expanded: {
      type: Boolean,
      default: true,
    },
  },

  data() {
    return {
      toggle: this.expanded,
    };
  },

  computed: {
    items() {
      return this.group.items.filter((item) => this.can(`${item.name}-show`));
    },
  },
});
</script>

<style lang="scss" scoped></style>
