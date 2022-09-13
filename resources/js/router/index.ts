import type { RouteConfig } from 'vue-router';
import Vue from 'vue';
import Router from 'vue-router';

import views from '@/views';
import generic from '@/views/generic';

import { resources } from './resources';

Vue.use(Router);

const routes: RouteConfig[] = [
  {
    path: '/',
    name: 'index',
    component: views.welcome,
    meta: { module: 'index', title: 'common.index', public: true },
  },
  {
    path: '/password/reset/:token',
    name: 'password',
    component: views.password,
    meta: { module: 'password', title: 'passwords.forgot.title', public: true },
  },
  {
    path: '/dashboard',
    name: 'dashboard',
    component: views.dashboard,
    meta: { module: 'dashboard', title: 'common.admin' },
  },
  {
    path: '/profile',
    name: 'profile',
    component: views.user.profile,
    meta: { module: 'user', title: 'common.profile' },
  },
  {
    path: '/profile/password',
    name: 'profile.password',
    component: views.user.password,
    meta: { module: 'user', title: 'common.profile' },
  },
];

const resolve = (module: string, action: string) => {
  return views[module] && views[module][action] ? views[module][action] : generic[action];
};

resources.forEach((item) => {
  if (!item.routes.length) return;

  const { name } = item;
  const meta = { module: name };

  routes.push({
    path: `/${name}`,
    name,
    component: resolve(name, 'list'),
    meta: { ...meta, ...{ title: `${name}.index`, perm: `${name}-show` } },
  });

  item.routes.forEach((route) => {
    if (route === 'create') {
      routes.push({
        path: `/${name}/create`,
        name: `${name}.create`,
        component: resolve(name, 'edit'),
        meta: { ...meta, ...{ title: `${name}.new`, perm: `${name}-create` } },
        props: true,
      });
      return;
    }

    routes.push({
      path: route === 'show' ? `/${name}/:id` : `/${name}/:id/${route}`,
      name: `${name}.${route}`,
      component: resolve(name, route),
      meta: {
        ...meta,
        perm: ['show', 'audit'].includes(route) ? `${name}-${route}` : `${name}-edit`,
      },
      props: true,
    });
  });
});

const router = new Router({
  mode: 'history',
  base: import.meta.env.VITE_URL_BASE ?? '/',
  routes,
});

export default router;
