<template>
  <div class="sidebar">
    <div class="sidebar-header">
      <router-link :to="{ name: 'index' }">
        <a class="brand"> <span class="fas fa-flask"></span> {{ $t('common.index') }} </a>
      </router-link>
    </div>
    <div class="sidebar-content">
      <div class="sidebar-menu">
        <nav class="mt-2">
          <ul class="nav nav-pills flex-column" role="menu">
            <li class="nav-item">
              <router-link :to="{ name: 'dashboard' }">
                <template #default="{ isExactActive }">
                  <a class="nav-link" :class="{ active: isExactActive }">
                    <span class="nav-icon fas fa-tachometer-alt"></span>
                    {{ $t('common.admin') }}
                  </a>
                </template>
              </router-link>
            </li>
            <menu-tree v-if="can(modules.lab.name)" :group="modules.lab"></menu-tree>
            <menu-tree v-if="can(modules.acl.name)" :group="modules.acl"></menu-tree>
            <menu-tree v-if="can(modules.advanced.name)" :group="modules.advanced"></menu-tree>
          </ul>
        </nav>
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent } from 'vue';

import { resourceGroups } from '@/router/resources';

import MenuTree from './MenuTree.vue';

export default defineComponent({
  name: 'Sidebar',

  components: { MenuTree },

  data() {
    return {
      modules: { ...resourceGroups },
    };
  },
});
</script>

<style lang="scss" scoped></style>
