<template>
  <div class="card bg-white mb-4">
    <div class="card-body">
      <div class="row justify-content-between">
        <div class="col-auto">
          <router-link :to="{ name: module }">
            <button class="btn btn-secondary" :title="$t(`common.back`)">
              <span class="fas fa-arrow-left" :title="$t(`common.back`)"></span>
              {{ $t(`common.back`) }}
            </button>
          </router-link>
        </div>
        <div class="col">
          <slot name="actions"></slot>
        </div>
        <div v-if="!isCreate" class="col-auto">
          <delete v-if="canDo('delete')" @action="onDelete"></delete>
        </div>
      </div>
    </div>
  </div>
  <div class="card">
    <div class="card-header">
      <ul class="nav nav-tabs card-header-tabs" role="tablist">
        <li v-for="tab in tabs" :key="tab" class="nav-item">
          <router-link
            :to="{ name: `${module}.${tab}`, params: tab === 'create' ? undefined : { id } }"
          >
            <template #default="{ isExactActive }">
              <a class="nav-link" :class="{ active: isExactActive }">
                {{ $t(`common.${tab}`) }}
              </a>
            </template>
          </router-link>
        </li>
      </ul>
    </div>
    <div class="tab-content">
      <slot></slot>
    </div>
  </div>
  <slot name="addons"></slot>
</template>

<script lang="ts">
import type { PropType } from 'vue';
import { defineComponent } from 'vue';

import type { Dictionary } from '@/types';
import Delete from '@/components/toolbar/Delete.vue';
import { resources } from '@/router/resources';
import { useMessages } from '@/stores';

import hasRefs from './has-refs';

export default defineComponent({
  name: 'EntryLayout',

  components: { Delete },

  mixins: [hasRefs],

  props: {
    id: {
      type: [Number, String],
      required: true,
    },
    entry: {
      type: Object as PropType<Dictionary>,
      required: true,
    },
  },

  computed: {
    tabs(): string[] {
      if (this.isCreate) return ['create'];

      const resource = resources.find((item) => item.name === this.module);
      if (!resource) return [];

      const routes = resource.routes.filter((item) => item !== 'create' && this.canDo(item));
      routes.push(
        ...routes.splice(
          routes.findIndex((v) => v === 'audit'),
          1
        )
      );
      return routes;
    },
    isCreate(): boolean {
      return this.$route.name === `${this.module}.create`;
    },
  },

  methods: {
    canDo(action: string) {
      if (['structure'].includes(action)) action = 'edit';

      const { perm = {} } = this.entry;
      if (action in perm) return perm[action];

      return this.can({ action });
    },

    async onDelete() {
      const { name } = this.entry;
      if (!confirm(this.$t('common.confirm.delete', { name }))) return;

      await this.$http.delete(`${this.module}/${this.id}`, { withLoading: true });
      useMessages().success(this.$t(`common.msg.deleted`, { name }));
      await this.$router.push({ name: this.module });
    },
  },
});
</script>
