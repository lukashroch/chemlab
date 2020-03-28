import Dashboard from './Dashboard';
import Welcome from './welcome/Welcome';
import PasswordReset from './welcome/PasswordReset';
import user from './user';
import permissions from './acl/permissions';
import roles from './acl/roles';
import teams from './acl/teams';
import users from './acl/users';
import backups from './advanced/backups';
import jobs from './advanced/jobs';
import logs from './advanced/logs';
import tasks from './advanced/tasks';
import brands from './lab/brands';
import chemicals from './lab/chemicals';
import stores from './lab/stores';

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
  backups,
  jobs,
  logs,
  tasks,
};
