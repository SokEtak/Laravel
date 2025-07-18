<?php

namespace App\Http\Controllers;

use App\Http\Requests\Roles\StoreRoleRequest;
use App\Http\Requests\Roles\UpdateRoleRequest;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class RoleController extends Controller
{
    public function index(): Response
    {
        $roles = Role::all();
        return Inertia::render('Roles/Index', [
            'roles' => $roles,
        ]);
    }

    public function create(): Response
    {
        $permissions = Permission::all(['id', 'name']);
        return Inertia::render('Roles/Create', [
            'permissions' => $permissions,
        ]);
    }

    public function store(StoreRoleRequest $request): RedirectResponse
    {
        $role = Role::create($request->validated());

        if ($request->has('permission_ids')) {
            $role->permissions()->attach($request->permission_ids);
        }

        return redirect()->route('roles.index')->with('success', 'Role created successfully!');
    }

    public function show(Role $role): Response
    {
        $role->load('permissions');
        return Inertia::render('Roles/Show', [
            'role' => $role,
        ]);
    }

    public function edit(Role $role): Response
    {
        $permissions = Permission::all(['id', 'name']);
        $rolePermissions = $role->permissions->pluck('id')->toArray();
        return Inertia::render('Roles/Edit', [
            'role' => $role,
            'permissions' => $permissions,
            'rolePermissions' => $rolePermissions,
        ]);
    }

    public function update(UpdateRoleRequest $request, Role $role): RedirectResponse
    {
        $role->update($request->validated());

        if ($request->has('permission_ids')) {
            $role->permissions()->sync($request->permission_ids);
        } else {
            $role->permissions()->detach();
        }

        return redirect()->route('roles.index')->with('success', 'Role updated successfully!');
    }

    public function destroy(Role $role): RedirectResponse
    {
        $role->delete();
        return redirect()->route('roles.index')->with('success', 'Role deleted successfully!');
    }
}
