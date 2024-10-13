<?php

use ChemLab\Models\Permission;
use ChemLab\Models\Role;
use ChemLab\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ACLSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        DB::table('permission_role')->truncate();
        DB::table('permission_user')->truncate();
        DB::table('role_user')->truncate();
        DB::table('users')->truncate();
        DB::table('roles')->truncate();
        DB::table('permissions')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');

        $permissions = [
            ['name' => 'lab', 'display_name' => 'Lab section'],
            ['name' => 'acl', 'display_name' => 'ACL section'],
            ['name' => 'advanced', 'display_name' => 'Advanced section'],

            ['name' => 'users-create', 'display_name' => 'Create users'],
            ['name' => 'users-show', 'display_name' => 'Browse users'],
            ['name' => 'users-edit', 'display_name' => 'Edit users'],
            ['name' => 'users-delete', 'display_name' => 'Delete users'],
            ['name' => 'users-restore', 'display_name' => 'Restore users'],
            ['name' => 'users-destroy', 'display_name' => 'Destroy users'],
            ['name' => 'users-audit', 'display_name' => 'Audit users'],

            ['name' => 'teams-create', 'display_name' => 'Create teams'],
            ['name' => 'teams-show', 'display_name' => 'Browse teams'],
            ['name' => 'teams-edit', 'display_name' => 'Edit teams'],
            ['name' => 'teams-delete', 'display_name' => 'Delete teams'],
            ['name' => 'teams-restore', 'display_name' => 'Restore teams'],
            ['name' => 'teams-destroy', 'display_name' => 'Destroy teams'],
            ['name' => 'teams-audit', 'display_name' => 'Audit teams'],

            ['name' => 'roles-create', 'display_name' => 'Create roles'],
            ['name' => 'roles-show', 'display_name' => 'Browse roles'],
            ['name' => 'roles-edit', 'display_name' => 'Edit roles'],
            ['name' => 'roles-delete', 'display_name' => 'Delete roles'],
            ['name' => 'roles-restore', 'display_name' => 'Restore roles'],
            ['name' => 'roles-destroy', 'display_name' => 'Destroy roles'],
            ['name' => 'roles-audit', 'display_name' => 'Audit roles'],

            ['name' => 'permissions-create', 'display_name' => 'Create permissions'],
            ['name' => 'permissions-show', 'display_name' => 'Browse permissions'],
            ['name' => 'permissions-edit', 'display_name' => 'Edit permissions'],
            ['name' => 'permissions-delete', 'display_name' => 'Delete permissions'],
            ['name' => 'permissions-restore', 'display_name' => 'Restore permissions'],
            ['name' => 'permissions-destroy', 'display_name' => 'Destroy permissions'],
            ['name' => 'permissions-audit', 'display_name' => 'Audit permissions'],

            ['name' => 'brands-create', 'display_name' => 'Create brands'],
            ['name' => 'brands-show', 'display_name' => 'Browse brands'],
            ['name' => 'brands-edit', 'display_name' => 'Edit brands'],
            ['name' => 'brands-delete', 'display_name' => 'Delete brands'],
            ['name' => 'brands-restore', 'display_name' => 'Restore brands'],
            ['name' => 'brands-destroy', 'display_name' => 'Destroy brands'],
            ['name' => 'brands-audit', 'display_name' => 'Audit brands'],

            ['name' => 'categories-create', 'display_name' => 'Create categories'],
            ['name' => 'categories-show', 'display_name' => 'Browse categories'],
            ['name' => 'categories-edit', 'display_name' => 'Edit categories'],
            ['name' => 'categories-delete', 'display_name' => 'Delete categories'],
            ['name' => 'categories-restore', 'display_name' => 'Restore categories'],
            ['name' => 'categories-destroy', 'display_name' => 'Destroy categories'],
            ['name' => 'categories-audit', 'display_name' => 'Audit categories'],

            ['name' => 'stores-create', 'display_name' => 'Create stores'],
            ['name' => 'stores-show', 'display_name' => 'Browse stores'],
            ['name' => 'stores-edit', 'display_name' => 'Edit stores'],
            ['name' => 'stores-delete', 'display_name' => 'Delete stores'],
            ['name' => 'stores-restore', 'display_name' => 'Restore stores'],
            ['name' => 'stores-destroy', 'display_name' => 'Destroy stores'],
            ['name' => 'stores-audit', 'display_name' => 'Audit stores'],

            ['name' => 'chemicals-create', 'display_name' => 'Create chemicals'],
            ['name' => 'chemicals-show', 'display_name' => 'Browse chemicals'],
            ['name' => 'chemicals-edit', 'display_name' => 'Edit chemicals'],
            ['name' => 'chemicals-delete', 'display_name' => 'Delete chemicals'],
            ['name' => 'chemicals-restore', 'display_name' => 'Restore chemicals'],
            ['name' => 'chemicals-destroy', 'display_name' => 'Destroy chemicals'],
            ['name' => 'chemicals-audit', 'display_name' => 'Audit chemicals'],

            ['name' => 'backups-create', 'display_name' => 'Create backups'],
            ['name' => 'backups-show', 'display_name' => 'Browse backups'],
            ['name' => 'backups-delete', 'display_name' => 'Delete backups'],

            ['name' => 'logs-show', 'display_name' => 'Browse logs'],
            ['name' => 'logs-delete', 'display_name' => 'Delete logs'],

            ['name' => 'tasks-show', 'display_name' => 'Browse tasks'],
            ['name' => 'tasks-cache', 'display_name' => 'Clear caches'],

            ['name' => 'audits-show', 'display_name' => 'Browse audits'],
        ];

        foreach ($permissions as $permission) {
            Permission::create($permission);
        }

        $role = Role::create([
            'name' => config('chemlab.superadmin'),
            'display_name' => ucfirst(config('chemlab.superadmin')),
        ]);

        $permissions = Permission::select('id')->pluck('id');
        $role->permissions()->sync($permissions);

        $user = User::create([
            'name' => 'admin',
            'email' => 'admin@localhost.com',
            'email_verified_at' => Carbon::now(),
            'password' => Hash::make('admin'),
        ]);

        $user->roles()->sync($role);
    }
}
