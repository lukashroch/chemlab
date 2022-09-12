import type Router from 'vue-router';

import { useResource, useUser } from '../stores';

export default (router: Router): void => {
  router.beforeEach(async (to, from, next) => {
    const { meta: { perm, public: isPublic } = {} } = to;

    const user = useUser();

    // Public pages except login page
    if (isPublic) {
      if (to.name === 'index' && user.loaded) next({ name: 'dashboard' });
      else next();
      return;
    }

    // Get logged-in user information if not yet loaded
    if (!user.loaded) await user.request();

    // Any other page (requires to be logged in)
    if (!user.loaded) {
      next({ name: 'index' });
      return;
    }

    // Check correct roles/permissions if any
    if (perm && !user.can(perm)) {
      next({ name: 'dashboard' });
      return;
    }

    next();
  });

  router.afterEach((to) => {
    const { meta: { module } = {} } = to;

    const resource = useResource();

    // Update module/resource name
    if (!resource.name !== module) resource.update(module);
  });
};
