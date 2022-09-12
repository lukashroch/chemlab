export default {
  audits: {
    fields: [
      {
        name: 'name',
        title: 'common.name',
        sortField: 'name',
      },
      {
        name: 'auditable_type',
        title: 'audits.type',
        sortField: 'auditable_type',
      },
      {
        name: 'auditable_name',
        title: 'audits.name',
        sortField: 'auditable_name',
      },
      {
        name: 'event',
        title: 'audits.event',
        sortField: 'event',
      },
      {
        name: 'created_at',
        title: 'common.created_at',
        sortField: 'created_at',
      },
    ],
    sortOrder: [
      {
        field: 'created_at',
        sortField: 'created_at',
        direction: 'desc',
      },
    ],
  },
  brands: {
    fields: [
      {
        name: 'name',
        title: 'common.name',
        sortField: 'name',
      },
      {
        name: 'name',
        title: 'brands.parse_callback',
        sortField: 'parse_callback',
      },
      {
        name: 'description',
        title: 'common.description',
        sortField: 'description',
      },
    ],
    sortOrder: [
      {
        field: 'name',
        sortField: 'name',
        direction: 'asc',
      },
    ],
  },
  backups: {
    fields: [
      {
        name: 'name',
        title: 'common.name',
        sortField: 'name',
        formatter: (value) => `<span class="fas fa-fw fa-file-code"></span> ${value}`,
      },
      {
        name: 'date',
        title: 'common.date',
        sortField: 'date',
        formatter: (value) => new Date(value * 1000).toLocaleString(),
      },
      {
        name: 'size',
        title: 'common.size',
        sortField: 'size',
        formatter: (value) => `${Math.floor((value / 1024) * 100) / 100} KB`,
      },
    ],
    sortOrder: [
      {
        field: 'date',
        sortField: 'date',
        direction: 'desc',
      },
    ],
  },
  chemicals: {
    fields: [
      {
        name: 'name',
        title: 'common.name',
        sortField: 'name',
      },
      {
        name: 'catalog_id',
        title: 'chemicals.brand.id',
        sortField: 'catalog_id',
      },
      {
        name: 'store',
        title: 'stores.title',
        sortField: 'store',
      },
      {
        name: 'amount',
        title: 'chemicals.amount',
      },
    ],
    sortOrder: [
      {
        field: 'name',
        sortField: 'name',
        direction: 'asc',
      },
    ],
  },
  jobs: {
    fields: [
      {
        name: 'id',
        title: 'common.id',
        sortField: 'id',
      },
      {
        name: 'queue',
        title: 'jobs.queue',
        sortField: 'queue',
      },
      {
        name: 'title',
        title: 'common.title',
      },
      {
        name: 'attempts',
        title: 'jobs.attempts',
        sortField: 'attempts',
      },
      {
        name: 'available_at',
        title: 'common.available_at',
        sortField: 'available_at',
      },
      {
        name: 'created_at',
        title: 'common.created_at',
        sortField: 'created_at',
      },
    ],
    sortOrder: [
      {
        field: 'created_at',
        sortField: 'created_at',
        direction: 'desc',
      },
    ],
  },
  logs: {
    fields: [
      {
        name: 'name',
        title: 'common.name',
        sortField: 'name',
        formatter: (value) => `<span class="fas fa-fw fa-file-code"></span> ${value}`,
      },
      {
        name: 'date',
        title: 'common.date',
        sortField: 'date',
        formatter: (value) => new Date(value * 1000).toLocaleString(),
      },
      {
        name: 'size',
        title: 'common.size',
        sortField: 'size',
        formatter: (value) => `${Math.floor((value / 1024) * 100) / 100} KB`,
      },
    ],
    sortOrder: [
      {
        field: 'date',
        sortField: 'date',
        direction: 'desc',
      },
    ],
  },
  permissions: {
    fields: [
      {
        name: 'name',
        title: 'common.title_internal',
        sortField: 'name',
      },
      {
        name: 'display_name',
        title: 'common.title',
        sortField: 'display_name',
      },
      {
        name: 'created_at',
        title: 'common.created_at',
        sortField: 'created_at',
      },
    ],
    sortOrder: [
      {
        field: 'name',
        sortField: 'name',
        direction: 'asc',
      },
    ],
  },
  roles: {
    fields: [
      {
        name: 'name',
        title: 'common.title_internal',
        sortField: 'name',
      },
      {
        name: 'display_name',
        title: 'common.title',
        sortField: 'display_name',
      },
      {
        name: 'created_at',
        title: 'common.created_at',
        sortField: 'created_at',
      },
    ],
    sortOrder: [
      {
        field: 'name',
        sortField: 'name',
        direction: 'asc',
      },
    ],
  },
  teams: {
    fields: [
      {
        name: 'name',
        title: 'common.title_internal',
        sortField: 'name',
      },
      {
        name: 'display_name',
        title: 'common.title',
        sortField: 'display_name',
      },
      {
        name: 'created_at',
        title: 'common.created_at',
        sortField: 'created_at',
      },
    ],
    sortOrder: [
      {
        field: 'name',
        sortField: 'name',
        direction: 'asc',
      },
    ],
  },
  users: {
    fields: [
      {
        name: 'name',
        title: 'common.name',
        sortField: 'name',
      },
      {
        name: 'email',
        title: 'common.email',
        sortField: 'email',
      },
      /*{
        name: 'roles',
        title: 'roles.index',
        formatter: value => (value ? value.join(', ') : '')
      },*/
      {
        name: 'created_at',
        title: 'common.created_at',
        sortField: 'created_at',
      },
    ],
    sortOrder: [
      {
        field: 'name',
        sortField: 'name',
        direction: 'asc',
      },
    ],
  },
};
