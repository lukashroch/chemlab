<template>
  <div class="sidebar">
    <div class="sidebar-header">
      <router-link tag="a" class="brand" :to="{ name: 'index' }">
        <span class="fas fa-fw fa-flask"></span> {{ $t('common.index') }}
      </router-link>
    </div>
    <div class="sidebar-content">
      <div class="sidebar-menu">
        <nav class="mt-2">
          <ul class="nav nav-pills flex-column" role="menu">
            <li class="nav-item">
              <router-link
                tag="a"
                class="nav-link"
                exact-active-class="active"
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

<script>
import MenuTree from './MenuTree';
import resources from '../../router/resources';

export default {
  name: 'Sidebar',

  components: { MenuTree },

  data() {
    return {
      modules: { ...resources }
    };
  }
};
</script>

<style lang="scss" scoped></style>
