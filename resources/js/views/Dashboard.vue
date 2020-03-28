<template>
  <div class="row">
    <div v-for="(group, key) in modules" :key="key" class="col-sm-6 col-md-4">
      <h2 class="my-3">{{ $t(`common.${group.name}`) }}</h2>
      <div class="list-group">
        <template v-for="item in group.items">
          <router-link
            tag="a"
            class="list-group-item list-group-item-action"
            :title="$t(item.title || `${item.name}.index`)"
            :to="{ name: item.name }"
            :key="item.name"
            v-if="can(`${item.name}-show`)"
          >
            <div class="d-flex align-items-center">
              <span :class="`fa-2x fa-fw ${item.icon} mr-2`"></span>
              <span class="h4 mb-0">{{ $t(item.title || `${item.name}.index`) }}</span>
            </div>
          </router-link>
        </template>
      </div>
    </div>
  </div>
</template>

<script>
import pickBy from 'lodash/pickBy';
import resources from '../router/resources';

export default {
  name: 'Dashboard',

  computed: {
    modules() {
      return pickBy(resources, (item) => this.can(item.name));
    },
  },
};
</script>

<style lang="scss" scoped></style>
