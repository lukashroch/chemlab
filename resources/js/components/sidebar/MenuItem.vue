<template>
  <li class="nav-item">
    <router-link active-class="active" class="nav-link" tag="a" :to="{ name: item.name }">
      <span :class="`fa-fw ${item.icon} mr-1`"></span>
      {{ $t(`${item.name}.index`) }}
    </router-link>
  </li>
</template>

<script>
export default {
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
};
</script>

<style lang="scss" scoped></style>
