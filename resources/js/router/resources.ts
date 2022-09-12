const routes: string[] = ['create', 'show', 'edit', 'audit'];

export type Resource = {
  name: string;
  title?: string;
  icon: string;
  routes: string[];
  status?: boolean;
};

export type ResourceGroup = {
  name: string;
  prefix?: string;
  icon: string;
  items: Resource[];
};

export type ResourceGroups = Record<'lab' | 'acl' | 'advanced', ResourceGroup>;

export const resourceGroups: ResourceGroups = {
  lab: {
    name: 'lab',
    icon: 'fas fa-flask',
    items: [
      {
        name: 'chemicals',
        icon: 'fas fa-flask',
        routes: [...routes, 'structure'],
      },
      {
        name: 'stores',
        icon: 'far fa-building',
        routes: [...routes],
      },
      {
        name: 'brands',
        icon: 'fas fa-barcode',
        routes: [...routes],
      },
    ],
  },
  acl: {
    name: 'acl',
    icon: 'fas fa-users-cog',
    items: [
      {
        name: 'teams',
        icon: 'fas fa-flag',
        routes: [...routes],
      },
      {
        name: 'users',
        icon: 'fas fa-users',
        routes: [...routes],
      },
      {
        name: 'roles',
        icon: 'far fa-id-badge',
        routes: [...routes],
      },
      {
        name: 'permissions',
        icon: 'far fa-eye-slash',
        routes: [...routes],
      },
    ],
  },
  advanced: {
    name: 'advanced',
    icon: 'fas fa-cogs',
    items: [
      {
        name: 'backups',
        icon: 'fas fa-server',
        routes: ['run'],
      },
      {
        name: 'tasks',
        icon: 'fas fa-tasks',
        routes: ['show'],
      },
      {
        name: 'jobs',
        icon: 'fas fa-running',
        routes: ['show'],
      },
      {
        name: 'logs',
        icon: 'fas fa-terminal',
        routes: ['show'],
      },
      {
        name: 'audits',
        icon: 'fas fa-search',
        routes: ['show'],
      },
    ],
  },
};

export const resources = Object.values(resourceGroups).reduce<Resource[]>((acc, group) => {
  acc.push(...group.items);
  return acc;
}, []);
