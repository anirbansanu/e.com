<?php

namespace App\Services\Permissions;

use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionService
{
    public function syncRolesForPermission(Permission $permission, array $roleIds)
    {
        $currentRoles = $permission->roles()->pluck('id')->toArray();

        // Roles to attach (new roles)
        $rolesToAttach = array_diff($roleIds, $currentRoles);
        foreach ($rolesToAttach as $roleId) {
            $role = Role::find($roleId);
            if ($role) {
                $role->givePermissionTo($permission->name);
            }
        }

        // Roles to detach (roles no longer assigned)
        $rolesToDetach = array_diff($currentRoles, $roleIds);
        foreach ($rolesToDetach as $roleId) {
            $role = Role::find($roleId);
            if ($role) {
                $role->revokePermissionTo($permission->name);
            }
        }
    }

    public function createPermission(array $data)
    {
        if (isset($data['permission_names'])) {
            // Bulk permission creation
            $permissionNames = explode(',', $data['permission_names']);
            $permissions = collect();

            foreach ($permissionNames as $name) {
                $permissionData = [
                    'name' => trim($name),
                    'guard_name' => $data['guard_name'],
                    'group_name' => $data['group_name'],
                    'group_order' => $data['group_order'],
                ];

                $permission = Permission::create($permissionData);
                $this->syncRolesForPermission($permission, $data['roles'] ?? []);
                $permissions->push($permission);
            }

            return $permissions;
        } else {
            // Single permission creation
            $permission = Permission::create($data);
            $this->syncRolesForPermission($permission, $data['roles'] ?? []);
            return $permission;
        }
    }

    public function updatePermission(Permission $permission, array $data)
    {
        $permission->update($data);
        $this->syncRolesForPermission($permission, $data['roles'] ?? []);
        return $permission;
    }

    public function deletePermission(Permission $permission)
    {
        $permission->delete();
    }
}
