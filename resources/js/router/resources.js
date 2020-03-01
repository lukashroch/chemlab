const routes = ['create', 'show', 'edit', 'audit'];

export default {
  lab: {
    name: 'lab',
    icon: 'fas fa-flask',
    items: [
      {
        name: 'chemicals',
        icon: 'fas fa-flask',
        routes: [...routes, 'structure']
      },
      {
        name: 'stores',
        icon: 'far fa-building',
        routes: [...routes]
      },
      {
        name: 'brands',
        icon: 'fas fa-barcode',
        routes: [...routes]
      }
    ]
  },
  acl: {
    name: 'acl',
    icon: 'fas fa-users-cog',
    items: [
      {
        name: 'teams',
        icon: 'fas fa-flag',
        routes: [...routes]
      },
      {
        name: 'users',
        icon: 'fas fa-users',
        routes: [...routes]
      },
      {
        name: 'roles',
        icon: 'far fa-id-badge',
        routes: [...routes]
      },
      {
        name: 'permissions',
        icon: 'far fa-eye-slash',
        routes: [...routes]
      }
    ]
  },
  advanced: {
    name: 'advanced',
    icon: 'fas fa-cogs',
    items: [
      {
        name: 'backups',
        icon: 'fas fa-server',
        routes: ['run']
      },
      {
        name: 'tasks',
        icon: 'fas fa-tasks',
        routes: ['show']
      },
      {
        name: 'jobs',
        icon: 'fas fa-running',
        routes: ['show']
      },
      {
        name: 'logs',
        icon: 'fas fa-terminal',
        routes: ['show']
      },
      {
        name: 'audits',
        icon: 'fas fa-search',
        routes: ['show']
      }
    ]
  }
};
