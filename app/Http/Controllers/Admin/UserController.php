<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $sort_by = $request->input('sort_by', 'updated_at');
        $sort_order = $request->input('sort_order', 'desc');
        $entries = $request->input('entries', config('app.pagination_limit'));

        $data = User::where(function ($query) use ($search) {
            $query->where('first_name', 'like', '%' . $search . '%')
                ->orWhere('last_name', 'like', '%' . $search . '%')
                ->orWhere('username', 'like', '%' . $search . '%')
                ->orWhere('email', 'like', '%' . $search . '%');
        })
        ->orderBy($sort_by, $sort_order)
        ->paginate($entries);

        $data->appends(['search' => $search, 'sort_by' => $sort_by, 'sort_order' => $sort_order, 'entries' => $entries]);
        return view('admin.users.index', compact('data', 'search', 'sort_by', 'sort_order', 'entries'));
    }

    public function create()
    {
        $roles = Role::all();
        return view('admin.users.create', compact('roles'));
    }

    public function store(StoreUserRequest $request)
    {
        $username = Str::slug($request->first_name) . rand(1000, 9999);
        $password = Str::random(12);

        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'username' => $username,
            'password' => Hash::make($password),
        ]);

        $user->assignRole($request->roles);

        return redirect()->route('users.index')->with('success', 'User created successfully. Username: ' . $username);
    }

    public function show($id)
    {
        $user = User::find($id);
        return view('admin.users.show', compact('user'));
    }

    public function edit($id)
    {
        $user = User::find($id);
        $roles = Role::all();
        $userRoles = $user->roles->pluck('name', 'name')->all();

        return view('admin.users.edit', compact('user', 'roles', 'userRoles'));
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $user->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'username' => $request->username,
        ]);

        $user->syncRoles($request->roles);

        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }

    public function destroy($id)
    {
        User::find($id)->delete();
        return redirect()->route('users.index')->with('success', 'User deleted successfully');
    }

    public function trash(Request $request)
    {
        $search = $request->input('search');
        $sort_by = $request->input('sort_by', 'updated_at');
        $sort_order = $request->input('sort_order', 'desc');
        $entries = $request->input('entries', config('app.pagination_limit'));

        $data = User::onlyTrashed()
            ->where(function ($query) use ($search) {
                $query->where('first_name', 'like', '%' . $search . '%')
                    ->orWhere('last_name', 'like', '%' . $search . '%')
                    ->orWhere('username', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%');
            })
            ->orderBy($sort_by, $sort_order)
            ->paginate($entries);

        return view('admin.users.trash', compact('data', 'entries', 'search', 'sort_by', 'sort_order'));
    }

    public function restore($id)
    {
        $user = User::withTrashed()->findOrFail($id);
        $user->restore();

        return redirect()->route('users.trash')->with('success', 'User restored successfully');
    }

    public function forceDelete($id)
    {
        $user = User::withTrashed()->findOrFail($id);
        $user->forceDelete();

        return redirect()->route('users.trash')->with('success', 'User deleted permanently');
    }
}
