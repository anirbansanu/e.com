<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        $permissions = [
            'users.index' => ['name' => 'users.index','guard_name' => 'web','group_name' => 'users','group_order' => 22],
                'users.create' => ['name' => 'users.create','guard_name' => 'web','group_name' => 'users','group_order' => 22],
                'users.store' => ['name' => 'users.store','guard_name' => 'web','group_name' => 'users','group_order' => 22],
                'users.edit' => ['name' => 'users.edit','guard_name' => 'web','group_name' => 'users','group_order' => 22],
                'users.update' => ['name' => 'users.update','guard_name' => 'web','group_name' => 'users','group_order' => 22],
                'users.destroy' => ['name' => 'users.destroy','guard_name' => 'web','group_name' => 'users','group_order' => 22],

            'admin.settings.roles.index' => ['name' => 'admin.settings.roles.index','guard_name' => 'web','group_name' => 'roles','group_order' => 22],
                'admin.settings.roles.create' => ['name' => 'admin.settings.roles.create','guard_name' => 'web','group_name' => 'roles','group_order' => 22],
                'admin.settings.roles.store' => ['name' => 'admin.settings.roles.store','guard_name' => 'web','group_name' => 'roles','group_order' => 22],
                'admin.settings.roles.edit' => ['name' => 'admin.settings.roles.edit','guard_name' => 'web','group_name' => 'roles','group_order' => 22],
                'admin.settings.roles.update' => ['name' => 'admin.settings.roles.update','guard_name' => 'web','group_name' => 'roles','group_order' => 22],
                'admin.settings.roles.destroy' => ['name' => 'admin.settings.roles.destroy','guard_name' => 'web','group_name' => 'roles','group_order' => 22],
                'admin.settings.roles.syncPermission'=> ['name' => 'admin.settings.roles.syncPermission','guard_name' => 'web','group_name' => 'roles','group_order' => 22],

                // Permission permissions
                'admin.settings.permissions.index' => [
                    'name' => 'admin.settings.permissions.index',
                    'guard_name' => 'web',
                    'group_name' => 'permissions',
                    'group_order' => 23
                ],
                'admin.settings.permissions.create' => [
                    'name' => 'admin.settings.permissions.create',
                    'guard_name' => 'web',
                    'group_name' => 'permissions',
                    'group_order' => 23
                ],
                'admin.settings.permissions.store' => [
                    'name' => 'admin.settings.permissions.store',
                    'guard_name' => 'web',
                    'group_name' => 'permissions',
                    'group_order' => 23
                ],
                'admin.settings.permissions.edit' => [
                    'name' => 'admin.settings.permissions.edit',
                    'guard_name' => 'web',
                    'group_name' => 'permissions',
                    'group_order' => 23
                ],
                'admin.settings.permissions.update' => [
                    'name' => 'admin.settings.permissions.update',
                    'guard_name' => 'web',
                    'group_name' => 'permissions',
                    'group_order' => 23
                ],
                'admin.settings.permissions.destroy' => [
                    'name' => 'admin.settings.permissions.destroy',
                    'guard_name' => 'web',
                    'group_name' => 'permissions',
                    'group_order' => 23
                ],
                'admin.settings.website' => [
                    'name' => 'admin.settings.website',
                    'guard_name' => 'web',
                    'group_name' => 'settings',
                    'group_order' => 23
                ],
                'admin.settings.website.update' => [
                    'name' => 'admin.settings.website.update',
                    'guard_name' => 'web',
                    'group_name' => 'settings',
                    'group_order' => 23
                ],
                'admin.settings.app' => [
                    'name' => 'admin.settings.app',
                    'guard_name' => 'web',
                    'group_name' => 'settings',
                    'group_order' => 23
                ],
                'admin.settings.app.update' => [
                    'name' => 'admin.settings.app.update',
                    'guard_name' => 'web',
                    'group_name' => 'settings',
                    'group_order' => 23
                ],
        ];

        foreach ($permissions as $permission) {
            if (is_array($permission)) {
                Permission::create($permission);
            } else {
                $this->command->error($permission['name'].' not created permission');
            }
        }

        // Create roles
        $adminRole = Role::where(['name' => 'admin'])->first();
        $userRole = Role::where(['name' => 'user'])->first();

        // Assign all permissions to admin role
        $adminRole->givePermissionTo(Permission::all());

        // Create admin user
        $adminUser = User::create([
            'first_name' => 'Sahil',
            'last_name' => 'User',
            'username' => 'sahil',
            'email' => 'sahil@admin.com',
            'password' => Hash::make('12345678'),
        ]);

        $adminUser->assignRole($adminRole);

        // Create a regular user
        $regularUser = User::create([
            'first_name' => 'Regular',
            'last_name' => 'Sahil',
            'username' => 'Sahiluser',
            'email' => 'sahil@user.com',
            'password' => Hash::make('12345678'),
        ]);

        $regularUser->assignRole($userRole);
    }
}
