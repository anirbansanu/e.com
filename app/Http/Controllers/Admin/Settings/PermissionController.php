<?php

namespace App\Http\Controllers\Admin\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
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

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255|unique:permissions,name',
            ]);

            if ($validator->fails()) {
                throw new ValidationException($validator);
            }

            Permission::create(['name' => $request->name,'guard_name'=>$request->guard_name,'group_name'=>$request->group_name,'group_order'=>$request->group_order]);
            return redirect()->route('permissions.index')->with('success', 'Permission created successfully');
        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->validator)->withInput();
        }
    }

    public function edit(Permission $permission)
    {
        return view('admin.permissions.create', compact('permission'));
    }

    public function update(Request $request, Permission $permission)
    {
        try
        {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255|unique:permissions,name,' . $permission->id,
            ]);

            if ($validator->fails()) {
                throw new ValidationException($validator);
            }

            $permission->update(['name' => $request->name,'group_name'=>$request->group_name,'group_order'=>$request->group_order]);
            return redirect()->route('permissions.index')->with('success', 'Permission updated successfully');
        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->validator)->withInput();
        }
    }

    public function destroy(Permission $permission)
    {
        $permission->delete();
        return redirect()->route('permissions.index')->with('success', 'Permission deleted successfully');
    }
}
