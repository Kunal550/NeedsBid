<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Gate;
use Illuminate\Auth\Access\AuthorizationException;

class RolePermissionController extends Controller
{
    public function index()
    {
        try {
            Gate::authorize('role-permission');
        } catch (AuthorizationException $e) {
            return redirect()->route('admin.dashboard')->with('error', 'You are not authorized to access that page.');
        }
        $roles = Role::with('permissions')->get();
        $permissions = Permission::all();

        return view('admin.panel.role-permissions.index', compact('roles', 'permissions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        try {
            Gate::authorize('role-permission-create');
        } catch (AuthorizationException $e) {
            return redirect()->route('admin.dashboard')->with('error', 'You are not authorized to access that page.');
        }
        
        $roles = Role::all();
        $permissions = Permission::all();

        return view('admin.panel.role-permissions.create', compact('roles', 'permissions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'role_id' => 'required|exists:roles,id',
            'permissions' => 'required|array',
            'permissions.*' => 'exists:permissions,id',
        ]);

        $role = Role::findOrFail($request->role_id);
        $permissions = Permission::whereIn('id', $request->permissions)->get();

        $role->syncPermissions($permissions);

        return redirect()->route('admin.role-permissions.index')
            ->with('success', 'Permissions assigned to role successfully.');
    }



    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        
        try {
            Gate::authorize('role-permission-edit');
        } catch (AuthorizationException $e) {
            return redirect()->route('admin.dashboard')->with('error', 'You are not authorized to access that page.');
        }

        $role = Role::with('permissions')->findOrFail($id);
        $permissions = Permission::all();

        return view('admin.panel.role-permissions.edit', compact('role', 'permissions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'permissions' => 'required|array',
            'permissions.*' => 'exists:permissions,id',
        ]);

        $role = Role::findOrFail($id);
        $permissions = Permission::whereIn('id', $request->permissions)->get();

        $role->syncPermissions($permissions);

        return redirect()->route('admin.role-permissions.list')
            ->with('success', 'Role permissions updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        
        try {
            Gate::authorize('role-permission-delete');
        } catch (AuthorizationException $e) {
            return redirect()->route('admin.dashboard')->with('error', 'You are not authorized to access that page.');
        }
        $role = Role::findOrFail($id);
        $role->syncPermissions([]);

        return redirect()->route('admin.role-permissions.list')
            ->with('success', 'All permissions removed from role.');
    }
}
