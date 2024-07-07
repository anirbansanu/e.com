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
        $permission = Permission::create($data);
        $this->syncRolesForPermission($permission, $data['roles'] ?? []);
        return $permission;
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
