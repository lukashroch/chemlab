<template>
  <div class="sidebar">
    <div class="sidebar-header">
      <router-link class="brand" tag="a" :to="{ name: 'index' }">
        <span class="fas fa-fw fa-flask"></span> {{ $t('common.index') }}
      </router-link>
    </div>
    <div class="sidebar-content">
      <div class="sidebar-menu">
        <nav class="mt-2">
          <ul class="nav nav-pills flex-column" role="menu">
            <li class="nav-item">
              <router-link
                class="nav-link"
                exact-active-class="active"
                tag="a"
                :to="{ name: 'dashboard' }"
              >
                <span class="nav-icon fas fa-fw fa-tachometer-alt"></span>
                {{ $t('common.admin') }}
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
