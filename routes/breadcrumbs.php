<?php

// Home
Breadcrumbs::for('home', function ($trail) {
    $trail->push(trans('common.home'), route('home'));
});

// Credits
Breadcrumbs::for('credits', function ($trail) {
    $trail->parent('home');
    $trail->push(trans('common.credits'), route('credits'));
});

// Home > Register
Breadcrumbs::for('register', function ($trail) {
    $trail->parent('home');
    $trail->push(trans('common.register'), route('register'));
});

// Home > Login
Breadcrumbs::for('login', function ($trail) {
    $trail->parent('home');
    $trail->push(trans('common.login'), route('login'));
});

// Home > Password Reset
Breadcrumbs::for('password.request', function ($trail) {
    $trail->parent('login');
    $trail->push(trans('user.password.reset'), route('password.request'));
});

// Home > Password Email
Breadcrumbs::for('password.reset', function ($trail, $token) {
    $trail->parent('login');
    $trail->push(trans('user.password.reset'), route('password.reset', $token));
});

// Home > Profile
Breadcrumbs::for('profile.index', function ($trail) {
    $trail->parent('home');
    $trail->push(trans('profile.index'), route('profile.index'));
});

// Home > Profile > Change password
Breadcrumbs::for('profile.password', function ($trail) {
    $trail->parent('profile.index');
    $trail->push(trans('user.password.change'), route('profile.update'));
});

// Home > Admin
Breadcrumbs::for('admin.index', function ($trail) {
    $trail->parent('home');
    $trail->push(trans('common.admin'), route('admin.index'));
});

// Home > Admin > Audits
Breadcrumbs::for('audits.index', function ($trail) {
    $trail->parent('home');
    $trail->push(trans('audits.index'), route('audits.index'));
});

// Home > Admin > Backups
Breadcrumbs::for('backups.index', function ($trail) {
    $trail->parent('home');
    $trail->push(trans('backups.index'), route('backups.index'));
});

// Home > Admin > Cache
Breadcrumbs::for('cache.index', function ($trail) {
    $trail->parent('home');
    $trail->push(trans('cache.index'), route('cache.index'));
});

// Home > Admin > Logs
Breadcrumbs::for('logs.index', function ($trail) {
    $trail->parent('home');
    $trail->push(trans('logs.index'), route('logs.index'));
});

// Home > Admin > Logs > [Log Name]
Breadcrumbs::for('logs.show', function ($trail, $log) {
    $trail->parent('logs.index');
    $trail->push($log, route('logs.show', $log));
});


// Home > Chemicals
Breadcrumbs::for('chemical.index', function ($trail) {
    $trail->parent('home');
    $trail->push(trans('chemical.index'), route('chemical.index'));
});

// Home > Chemicals > Create
Breadcrumbs::for('chemical.create', function ($trail) {
    $trail->parent('chemical.index');
    $trail->push(trans('chemical.new'), route('chemical.create'));
});

// Home > Chemicals > [Chemical Name]
Breadcrumbs::for('chemical.show', function ($trail, $chemical) {
    $trail->parent('chemical.index');
    $trail->push($chemical->name, route('chemical.show', $chemical));
});

// Home > Chemical > [Chemical Name] > Edit Chemical
Breadcrumbs::for('chemical.edit', function ($trail, $chemical) {
    $trail->parent('chemical.show', $chemical);
    $trail->push(trans('chemical.edit'), route('chemical.edit', $chemical));
});

// Home > Stores
Breadcrumbs::for('store.index', function ($trail) {
    $trail->parent('home');
    $trail->push(trans('store.index'), route('store.index'));
});

// Home > Stores > Create
Breadcrumbs::for('store.create', function ($trail) {
    $trail->parent('store.index');
    $trail->push(trans('store.new'), route('store.create'));
});

// Home > Stores > [Store Name]
Breadcrumbs::for('store.show', function ($trail, $store) {
    $trail->parent('store.index');
    $trail->push($store->name, route('store.show', $store));
});

// Home > Stores > [Store Name] > Edit Store
Breadcrumbs::for('store.edit', function ($trail, $store) {
    $trail->parent('store.show', $store);
    $trail->push(trans('store.edit'), route('store.edit', $store));
});

// Home > Brands
Breadcrumbs::for('brand.index', function ($trail) {
    $trail->parent('home');
    $trail->push(trans('brand.index'), route('brand.index'));
});

// Home > Brands > Create
Breadcrumbs::for('brand.create', function ($trail) {
    $trail->parent('brand.index');
    $trail->push(trans('brand.new'), route('brand.create'));
});

// Home > Brands > [Brand Name]
Breadcrumbs::for('brand.show', function ($trail, $brand) {
    $trail->parent('brand.index');
    $trail->push($brand->name, route('brand.show', $brand));
});

// Home > Brands > [Brand Name] > Edit Brand
Breadcrumbs::for('brand.edit', function ($trail, $brand) {
    $trail->parent('brand.show', $brand);
    $trail->push(trans('brand.edit'), route('brand.edit', $brand));
});

// Home > NMR
Breadcrumbs::for('nmr.index', function ($trail) {
    $trail->parent('home');
    $trail->push(trans('nmr.index'), route('nmr.index'));
});

// Home > NMR > Create
Breadcrumbs::for('nmr.create', function ($trail) {
    $trail->parent('nmr.index');
    $trail->push(trans('nmr.new'), route('nmr.create'));
});

// Home > NMR > [NMR Name]
Breadcrumbs::for('nmr.show', function ($trail, $nmr) {
    $trail->parent('nmr.index');
    $trail->push($nmr->name, route('nmr.show', $nmr));
});

// Home > NMR > [NMR Name] > Edit NMR
Breadcrumbs::for('nmr.edit', function ($trail, $nmr) {
    $trail->parent('nmr.show', $nmr);
    $trail->push(trans('nmr.edit'), route('nmr.edit', $nmr));
});

// Home > Users
Breadcrumbs::for('user.index', function ($trail) {
    $trail->parent('home');
    $trail->push(trans('user.index'), route('user.index'));
});

// Home > Users > Create
Breadcrumbs::for('user.create', function ($trail) {
    $trail->parent('user.index');
    $trail->push(trans('user.new'), route('user.create'));
});

// Home > Users > [User Name]
Breadcrumbs::for('user.show', function ($trail, $user) {
    $trail->parent('user.index');
    $trail->push($user->name, route('user.show', $user));
});

// Home > Users > [User Name] > Edit User
Breadcrumbs::for('user.edit', function ($trail, $user) {
    $trail->parent('user.show', $user);
    $trail->push(trans('user.edit'), route('user.edit', $user));
});

// Home > Roles
Breadcrumbs::for('role.index', function ($trail) {
    $trail->parent('home');
    $trail->push(trans('role.index'), route('role.index'));
});

// Home > Roles > Create
Breadcrumbs::for('role.create', function ($trail) {
    $trail->parent('role.index');
    $trail->push(trans('role.new'), route('role.create'));
});

// Home > Roles > [Role Name]
Breadcrumbs::for('role.show', function ($trail, $role) {
    $trail->parent('role.index');
    $trail->parent('role.index');
    $trail->push($role->display_name, route('role.show', $role));
});

// Home > Admin > Roles > [Role Name] > Edit Role
Breadcrumbs::for('role.edit', function ($trail, $role) {
    $trail->parent('role.show', $role);
    $trail->push(trans('role.edit'), route('role.edit', $role));
});

// Home > Permissions
Breadcrumbs::for('permission.index', function ($trail) {
    $trail->parent('home');
    $trail->push(trans('permission.index'), route('permission.index'));
});

// Home > Permissions > Create
Breadcrumbs::for('permission.create', function ($trail) {
    $trail->parent('permission.index');
    $trail->push(trans('permission.new'), route('permission.create'));
});

// Home > Permissions > [Permission Name]
Breadcrumbs::for('permission.show', function ($trail, $permission) {
    $trail->parent('permission.index');
    $trail->push($permission->display_name, route('permission.show', $permission));
});

// Home > Permissions > [Permission Name] > Edit Permission
Breadcrumbs::for('permission.edit', function ($trail, $permission) {
    $trail->parent('permission.show', $permission);
    $trail->push(trans('permission.edit'), route('permission.edit', $permission));
});

// Home > Teams
Breadcrumbs::for('team.index', function ($trail) {
    $trail->parent('home');
    $trail->push(trans('team.index'), route('team.index'));
});

// Home > Teams > Create
Breadcrumbs::for('team.create', function ($trail) {
    $trail->parent('team.index');
    $trail->push(trans('team.new'), route('team.create'));
});

// Home > Teams > [Team Name]
Breadcrumbs::for('team.show', function ($trail, $team) {
    $trail->parent('team.index');
    $trail->push($team->display_name, route('team.show', $team));
});

// Home > Teams > [Team Name] > Edit Team
Breadcrumbs::for('team.edit', function ($trail, $team) {
    $trail->parent('team.show', $team);
    $trail->push(trans('team.edit'), route('team.edit', $team));
});
