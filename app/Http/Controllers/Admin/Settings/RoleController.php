<?php

namespace App\Http\Controllers\Admin\Settings;

// app/Http/Controllers/Admin/Settings/RoleController.php


use App\Http\Controllers\Controller;
use App\Http\Requests\Roles\StoreRoleRequest;
use App\Http\Requests\Roles\UpdateRoleRequest;
use App\Services\Roles\RoleService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    protected $roleService;

    public function __construct(RoleService $roleService)
    {
        $this->roleService = $roleService;
    }

    public function index(Request $request)
    {
        $search = $request->input('search');
        $sort_by = $request->input('sort_by', 'updated_at');
        $sort_order = $request->input('sort_order', 'desc');
        $entries = $request->input('entries', config('app.pagination_limit'));

        $roles = $this->roleService->getAllRoles($search, $sort_by, $sort_order, $entries);
        $roles->appends(['search' => $search, 'sort_by' => $sort_by, 'sort_order' => $sort_order, 'entries' => $entries]);

        return view('admin.settings.roles.index', compact('roles', 'search', 'sort_by', 'sort_order', 'entries'));
    }

    public function create()
    {
        $permissions = $this->roleService->permissions();
        return view('admin.settings.roles.create', compact('permissions'));
    }

    public function store(StoreRoleRequest $request)
    {
        $role = $this->roleService->createRole($request->input('name'), $request->input('perm'));
        return redirect()->route('admin.settings.roles.index')->with('success', "Role $role->name created successfully");
    }

    public function show($id)
    {
        $role = $this->roleService->getRoleById($id);
        $rolePermissions = Permission::join("role_has_permissions", "role_has_permissions.permission_id", "=", "permissions.id")
            ->where("role_has_permissions.role_id", $id)
            ->get();

        return view('admin.settings.roles.show', compact('role', 'rolePermissions'));
    }

    public function edit($id)
    {
        $role = $this->roleService->getRoleById($id);
        $permissions = $this->roleService->permissions();
        $rolePermissions = DB::table("role_has_permissions")->where("role_has_permissions.role_id", $id)
            ->pluck('role_has_permissions.permission_id', 'role_has_permissions.permission_id')
            ->all();

        return view('admin.settings.roles.create', compact('role', 'permissions', 'rolePermissions'));
    }

    public function update(UpdateRoleRequest $request, $id)
    {
        $role = $this->roleService->updateRole($id, $request->input('name'), $request->input('perm'));
        return redirect()->back()->with('success', "Role $role->name updated successfully");
    }

    public function destroy($id)
    {
        try {
            $role = $this->roleService->deleteRole($id);
            return redirect()->route('admin.settings.roles.index')->with('success', "Role $role->name deleted successfully");
        } catch (\Exception $e) {
            return redirect()->route('admin.settings.roles.index')->with('error', 'An error occurred while deleting the role: ' . $e->getMessage());
        }
    }
}

