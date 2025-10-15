<?php

namespace Modules\UserRoles\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Yajra\DataTables\Facades\DataTables;

class RoleController extends Controller
{
    /**
     * Display all roles with their permissions.
     */
    public function index(Request $request)
    {
        breadcrumb()->reset()
            ->add('Dashboard', route('dashboard'))
            ->add('Roles', route('roles.index'));
    
        if ($request->ajax()) {
            $roles = Role::with('permissions');
    
            return DataTables::of($roles)
                ->addIndexColumn()
                ->addColumn('permissions', function ($role) {
                    return $role->permissions->map(function ($perm) {
                        return "<span class='badge bg-info bg-opacity-10 text-info fw-semibold me-1 mb-1'>{$perm->name}</span>";
                    })->implode(' ');
                })
                ->addColumn('created_at', function ($role) {
                    return $role->created_at->format('M d, Y');
                })
                ->addColumn('action', function ($role) {
                    $escapedName = e($role->name);
                
                    return <<<HTML
                        <button type="button" class="btn btn-sm btn-primary edit-btn btn-action"
                            data-bs-toggle="modal"
                            data-bs-target="#editModal"
                            data-id="{$role->id}"
                            data-name="{$escapedName}">
                            <i class="bi bi-pencil-square me-1"></i> Edit
                        </button>
                        <button type="button" class="btn btn-sm btn-danger delete-btn btn-action"
                            data-bs-toggle="modal"
                            data-bs-target="#deleteModal"
                            data-id="{$role->id}"
                            data-name="{$escapedName}">
                            <i class="bi bi-trash me-1"></i> Delete
                        </button>
                    HTML;
                })                
                ->rawColumns(['permissions', 'action'])
                ->make(true);
        }
    
        $permissions = Permission::all();
    
        return view('userroles::roles.index', compact('permissions'));
    }

    /**
     * Store a newly created role.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:roles,name',
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,id',
        ]);

        $role = Role::create(['name' => $request->name]);

        if ($request->filled('permissions')) {
            $permissionNames = Permission::whereIn('id', $request->permissions)->pluck('name');
            $role->syncPermissions($permissionNames);
        }

        return redirect()->route('roles.index')->with('success', 'Role created successfully.');
    }

    /**
     * Return role data and its permissions (used in edit modal via AJAX).
     */
    public function show($id)
    {
        $role = Role::with('permissions:id,name')->findOrFail($id);

        return response()->json([
            'id' => $role->id,
            'name' => $role->name,
            'permissions' => $role->permissions,
        ]);
    }

    /**
     * Update the specified role.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|unique:roles,name,' . $id,
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,id',
        ]);

        $role = Role::findOrFail($id);
        $role->update(['name' => $request->name]);

        if ($request->filled('permissions')) {
            $permissionNames = Permission::whereIn('id', $request->permissions)->pluck('name');
            $role->syncPermissions($permissionNames);
        } else {
            $role->syncPermissions([]);
        }

        return redirect()->route('roles.index')->with('success', 'Role updated successfully.');
    }

    /**
     * Remove the specified role.
     */
    public function destroy($id)
    {
        $role = Role::findOrFail($id);
        $role->delete();

        return redirect()->route('roles.index')->with('success', 'Role deleted successfully.');
    }
}
