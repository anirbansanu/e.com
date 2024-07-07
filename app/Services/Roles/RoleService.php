<?php
// app/Services/RoleService.php
namespace App\Services\Roles;

use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
use Exception;
use Spatie\Permission\Models\Permission;

class RoleService
{
    public function getAllRoles($search, $sort_by, $sort_order, $entries)
    {
        return Role::where(function ($query) use ($search) {
            $query->where('name', 'like', '%' . $search . '%');
        })
            ->orderBy($sort_by, $sort_order)
            ->paginate($entries);
    }

    public function createRole($name, $permissions)
    {
        $role = Role::create(['name' => $name]);
        $role->syncPermissions($permissions);
        return $role;
    }

    public function getRoleById($id)
    {
        return Role::find($id);
    }

    public function updateRole($id, $name, $permissions)
    {
        $role = Role::find($id);
        $role->name = $name;
        $role->save();
        $role->syncPermissions($permissions);
        return $role;
    }

    public function deleteRole($id)
    {
        $role = Role::find($id);
        if (!$role) {
            throw new Exception('Role not found');
        }
        $role->delete();
        return $role;
    }

    public function permissions()
    {
        return Permission::orderBy('group_order')
            ->orderBy('group_name')
            ->get()->groupBy('group_name');
    }
}
