<template>
  <div class="row">
    <div v-for="(group, key) in modules" :key="key" class="col-sm-6 col-md-4">
      <h2 class="my-3">{{ $t(`common.${group.name}`) }}</h2>
      <div class="list-group">
        <template v-for="item in group.items">
          <router-link
            v-if="can(`${item.name}-show`)"
            :key="item.name"
            class="list-group-item list-group-item-action"
            tag="a"
            :title="$t(item.title || `${item.name}.index`)"
            :to="{ name: item.name }"
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

<script lang="ts">
import pickBy from 'lodash/pickBy';
import { defineComponent } from 'vue';

import { resourceGroups } from '@/router/resources';

export default defineComponent({
  name: 'Dashboard',

  computed: {
    modules() {
      return pickBy(resourceGroups, (item) => this.can(item.name));
    },
  },
});
</script>

<style lang="scss" scoped></style>
