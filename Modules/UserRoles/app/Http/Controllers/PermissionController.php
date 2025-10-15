<?php

namespace Modules\UserRoles\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\UserRoles\Models\Permission;
use Yajra\DataTables\Facades\DataTables;

class PermissionController extends Controller
{
    // public function index()
    // {
    //     $permissions = Permission::all();
    //     return view('userroles::permissions.index', compact('permissions'));
    // }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $permissions = Permission::with('roles');

            return DataTables::of($permissions)
                ->addIndexColumn()

                // Humanize the permission name using your custom function
                ->addColumn('name', function ($permission) {
                    return humanize_string($permission->name);
                })

                ->addColumn('roles', function ($permission) {
                    return $permission->roles->map(function ($role) {
                        return "<span class='badge bg-info bg-opacity-10 text-info fw-semibold me-1 mb-1'>{$role->name}</span>";
                    })->implode(' ');
                })

                ->addColumn('category', function ($permission) {
                    return $permission->category ?? '-';
                })

                ->addColumn('action', function ($permission) {
                    return <<<HTML
                <button type="button" class="btn btn-sm btn-primary edit-btn btn-action"
                    data-id="{$permission->id}" data-bs-toggle="modal" data-bs-target="#editModal">
                    <i class="bi bi-pencil-square me-1"></i> Edit
                </button>
                <button type="button" class="btn btn-sm btn-danger delete-btn btn-action"
                    data-id="{$permission->id}" data-bs-toggle="modal" data-bs-target="#deleteModal">
                    <i class="bi bi-trash me-1"></i> Delete
                </button>
                HTML;
                })

                ->rawColumns(['roles', 'action'])
                ->make(true);
        }

        return view('userroles::permissions.index');
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:permissions,name',
            'category' => 'required|string',
        ]);

        Permission::create([
            'name' => $request->name,
            'category' => $request->category,
        ]);

        return redirect()->route('permissions.index')->with('success', 'Permission created successfully');
    }

    public function show($id)
    {
        $permission = Permission::findOrFail($id);

        return response()->json([
            'id' => $permission->id,
            'name' => $permission->name,
            'category' => $permission->category,
            'created_at' => $permission->created_at,
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|unique:permissions,name,' . $id,
            'category' => 'required|string',
        ]);

        $permission = Permission::findOrFail($id);
        $permission->update([
            'name' => $request->name,
            'category' => $request->category,
        ]);

        return redirect()->route('permissions.index')->with('success', 'Permission updated successfully.');
    }

    public function destroy($id)
    {
        $permission = Permission::findOrFail($id);
        $permission->delete();

        return redirect()->route('permissions.index')->with('success', 'Permission deleted successfully.');
    }
}
