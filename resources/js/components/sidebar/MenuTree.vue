<template>
  <li class="nav-item">
    <div class="nav-link d-flex align-items-center nav-header" @click="toggle = !toggle">
      <span :class="`fas fa-fw ${group.icon} mr-1`"></span>
      <span class="flex-fill">{{ $t(`common.${group.name}`) }}</span>
      <span class="fas fa-fw fa-angle-down" :class="{ 'fa-rotate-90': !toggle }"></span>
    </div>
    <collapse :active="toggle" tag="div">
      <ul class="nav nav-pills flex-column">
        <menu-item v-for="item in items" :key="item.name" :item="item"></menu-item>
      </ul>
    </collapse>
  </li>
</template>

<script>
import MenuItem from './MenuItem.vue';

export default {
  name: 'MenuTree',

  components: { MenuItem },

  props: {
    group: {
      type: Object,
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
};
</script>

<style lang="scss" scoped></style>
