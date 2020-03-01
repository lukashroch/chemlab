import Vue from 'vue';
import Router from 'vue-router';
import store from '../store';
import resources from './resources';
import views from '../views';
import List from '../views/generic/DataList.vue';
import Detail from '../views/generic/Detail.vue';
import Audit from '../components/Audit.vue';

Vue.use(Router);

const generic = {
  list: List,
  detail: Detail,
  audit: Audit
};

const routes = [
  {
    path: '/',
    name: 'index',
    component: views.welcome,
    meta: { module: 'index', title: 'common.index', public: true }
  },
  {
    path: '/password/reset/:token',
    name: 'password',
    component: views.password,
    meta: { module: 'password', title: 'passwords.forgot.title', public: true }
  },
  {
    path: '/dashboard',
    name: 'dashboard',
    component: views.dashboard,
    meta: { module: 'dashboard', title: 'common.admin' }
  },
  {
    path: '/profile',
    name: 'profile',
    component: views.user.profile,
    meta: { module: 'user', title: 'common.profile' }
  },
  {
    path: '/profile/password',
    name: 'profile.password',
    component: views.user.password,
    meta: { module: 'user', title: 'common.profile' }
  }
];

const resolve = (module, action) => {
  return views[module] && views[module][action] ? views[module][action] : generic[action];
};

Object.values(resources).reduce((acc, resource) => {
  resource.items.forEach(item => {
    const { name } = item;
    const meta = { module: name };

    acc.push({
      path: `/${name}`,
      name,
      component: resolve(name, 'list'),
      meta: { ...meta, ...{ title: `${name}.index`, perm: `${name}-show` } }
    });

    const cDetail = resolve(name, 'detail');

    if (item.routes.includes('create')) {
      acc.push({
        path: `/${name}/create`,
        component: cDetail,
        meta,
        children: [
          {
            path: '',
            name: `${name}.create`,
            component: resolve(name, 'edit'),
            meta: { ...meta, ...{ title: `${name}.new`, perm: `${name}-create` } }
          }
        ]
      });
    }

    const detail = {
      path: `/${name}/:id`,
      component: cDetail,
      children: [],
      meta,
      props: true
    };

    item.routes.forEach(route => {
      if (route === 'create') return;

      detail.children.push({
        path: route === 'show' ? '' : route,
        name: `${name}.${route}`,
        //component: resolve(name, route),
        components: {
          default: resolve(name, route),
          addons: name === 'chemicals' ? views.chemicals.items : undefined
        },
        meta: {
          ...meta,
          perm: ['show', 'audit'].includes(route) ? `${name}-${route}` : `${name}-edit`
        },
        props: {
          default: true,
          addons: true
        }
      });
    });

    acc.push(detail);
  });

  return acc;
}, routes);

const router = new Router({
  mode: 'history',
  scrollBehavior: () => ({ y: 0 }),
  base: process.env.MIX_URL_ADMIN,
  routes
});

router.beforeEach(async (to, from, next) => {
  // Public pages except login page
  if (to.meta.public) {
    if (to.name === 'index' && store.getters['user/loaded']) next({ name: 'dashboard' });
    else next();
    return;
  }

  // Get logged-in user information if not yet loaded
  if (!store.getters['user/loaded']) await store.dispatch('user/request');

  // Any other page (requires to be logged in)
  if (!store.getters['user/loaded']) {
    next({ name: 'index' });
    return;
  }

  // Check correct roles/permissions if any
  if (to.meta.perm && !store.getters['user/can'](to.meta.perm)) {
    next({ name: 'dashboard' });
    return;
  }

  next();
});

export default router;
