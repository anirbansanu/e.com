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

            'roles.index' => ['name' => 'roles.index','guard_name' => 'web','group_name' => 'roles','group_order' => 22],
                'roles.create' => ['name' => 'roles.create','guard_name' => 'web','group_name' => 'roles','group_order' => 22],
                'roles.store' => ['name' => 'roles.store','guard_name' => 'web','group_name' => 'roles','group_order' => 22],
                'roles.edit' => ['name' => 'roles.edit','guard_name' => 'web','group_name' => 'roles','group_order' => 22],
                'roles.update' => ['name' => 'roles.update','guard_name' => 'web','group_name' => 'roles','group_order' => 22],
                'roles.destroy' => ['name' => 'roles.destroy','guard_name' => 'web','group_name' => 'roles','group_order' => 22],
                'roles.syncPermission'=> ['name' => 'roles.syncPermission','guard_name' => 'web','group_name' => 'roles','group_order' => 22],

                // Permission permissions
                'permissions.index' => [
                    'name' => 'permissions.index',
                    'guard_name' => 'web',
                    'group_name' => 'permissions',
                    'group_order' => 23
                ],
                'permissions.create' => [
                    'name' => 'permissions.create',
                    'guard_name' => 'web',
                    'group_name' => 'permissions',
                    'group_order' => 23
                ],
                'permissions.store' => [
                    'name' => 'permissions.store',
                    'guard_name' => 'web',
                    'group_name' => 'permissions',
                    'group_order' => 23
                ],
                'permissions.edit' => [
                    'name' => 'permissions.edit',
                    'guard_name' => 'web',
                    'group_name' => 'permissions',
                    'group_order' => 23
                ],
                'permissions.update' => [
                    'name' => 'permissions.update',
                    'guard_name' => 'web',
                    'group_name' => 'permissions',
                    'group_order' => 23
                ],
                'permissions.destroy' => [
                    'name' => 'permissions.destroy',
                    'guard_name' => 'web',
                    'group_name' => 'permissions',
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
            'first_name' => 'Admin',
            'last_name' => 'User',
            'username' => 'admin1998',
            'email' => 'admin@admin1998.com',
            'password' => Hash::make('12345678'),
        ]);

        $adminUser->assignRole($adminRole);

        // Create a regular user
        $regularUser = User::create([
            'first_name' => 'Regular',
            'last_name' => 'User',
            'username' => '1998user',
            'email' => 'user@1998user.com',
            'password' => Hash::make('12345678'),
        ]);

        $regularUser->assignRole($userRole);
    }
}
