<?php

namespace App\Http\Controllers\Admin\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\Permissions\PermissionRequest;
use App\Services\Permissions\PermissionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    protected $permissionService;

    public function __construct(PermissionService $permissionService)
    {
        $this->permissionService = $permissionService;
    }

    public function index(Request $request)
    {
        $search = $request->input('search');
        $sort_by = $request->input('sort_by', 'updated_at');
        $sort_order = $request->input('sort_order', 'desc');
        $entries = $request->input('entries', config('app.pagination_limit'));

        $permissions = Permission::with(['roles'=>function($sql){ return $sql->select('id'); }])
        ->where(function ($query) use ($search) {
            $query->where('name', 'like', '%' . $search . '%')
            ->Orwhere('group_name', 'like', '%' . $search . '%');
        })
        ->orderBy($sort_by, $sort_order)
        ->paginate($entries);

        $permissions_array = $permissions->groupBy('group_name');

        $permissions->appends(['search' => $search, 'sort_by' => $sort_by, 'sort_order' => $sort_order, 'entries' => $entries]);
        return view('admin.settings.permissions.index', compact('permissions','permissions_array', 'search', 'sort_by', 'sort_order', 'entries'));
    }

    public function create()
    {
        $roles = Role::orderBy('guard_name')
        ->orderBy('guard_name')
        ->get()->groupBy('guard_name');
        return view('admin.settings.permissions.create',compact('roles'));
    }

    public function store(PermissionRequest $request)
    {
        $data = $request->validated();
        $permission = $this->permissionService->createPermission($data);
        if(is_array($permission))
        return redirect()->back()->with('success', "Permission '{$permission->name}' created successfully");
        else
        return redirect()->back()->with('success', "Permissions created successfully");
    }

    public function edit(Permission $permission)
    {
        $roles = Role::orderBy('guard_name')
        ->orderBy('guard_name')
        ->get()->groupBy('guard_name');

        $rolesByPermission = DB::table("role_has_permissions")->where("role_has_permissions.permission_id", $permission->id)
            ->pluck('role_has_permissions.role_id', 'role_has_permissions.role_id')
            ->all();

        return view('admin.settings.permissions.create', compact('permission','roles','rolesByPermission'));
    }

    public function update(PermissionRequest $request, Permission $permission)
    {
        $data = $request->validated();
        $this->permissionService->updatePermission($permission, $data);
        return redirect()->back()->with('success', "Permission '{$permission->name}' updated successfully");
    }

    public function destroy(Permission $permission)
    {
        $this->permissionService->deletePermission($permission);
        return redirect()->back()->with('success', 'Permission deleted successfully');
    }
}
