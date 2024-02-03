<template>
  <li class="nav-item">
    <router-link :to="{ name: item.name }">
      <template #default="{ isActive }">
        <a class="nav-link" :class="{ active: isActive }">
          <span :class="`fa-fw ${item.icon} me-1`"></span>
          {{ $t(`${item.name}.index`) }}
        </a>
      </template>
    </router-link>
  </li>
</template>

<script lang="ts">
import { defineComponent } from 'vue';

export default defineComponent({
  name: 'MenuItem',

  props: {
    item: {
      type: Object,
      required: true,
    },
    active: {
      type: Boolean,
      default: false,
    },
  },

  data() {
    return {
      status: 0,
    };
  },
});
</script>

<style lang="scss" scoped></style>
