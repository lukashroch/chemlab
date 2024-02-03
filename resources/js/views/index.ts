import type { Dictionary } from '@/types';

import permissions from './acl/permissions';
import roles from './acl/roles';
import teams from './acl/teams';
import users from './acl/users';
import audits from './advanced/audits';
import backups from './advanced/backups';
import jobs from './advanced/jobs';
import logs from './advanced/logs';
import tasks from './advanced/tasks';
import Dashboard from './Dashboard.vue';
import brands from './lab/brands';
import chemicals from './lab/chemicals';
import stores from './lab/stores';
import user from './user';
import PasswordReset from './welcome/PasswordReset.vue';
import Welcome from './welcome/Welcome.vue';

export default {
  welcome: Welcome,
  password: PasswordReset,
  dashboard: Dashboard,
  user: user,
  // Lab
  brands,
  chemicals,
  stores,
  // ACL
  permissions,
  roles,
  teams,
  users,
  // Advanced
  audits,
  backups,
  jobs,
  logs,
  tasks,
} as Dictionary;
