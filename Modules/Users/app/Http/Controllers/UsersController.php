<?php

namespace Modules\Users\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Modules\UserRoles\Models\Role;
use Modules\Users\Models\User;
use Yajra\DataTables\Facades\DataTables;

class UsersController extends Controller
{
    public function index(Request $request)
    {
        $authUser = auth()->user();

        abort_if($authUser->hasRole('user'), 403, 'You are not authorized to view the user list.');

        breadcrumb()->reset()
            ->add('Dashboard', route('dashboard'))
            ->add('Users', route('users.index'));

        if ($request->ajax()) {
            $query = User::query();

            // Role-based filtering
            if ($authUser->hasRole('superadmin') && $authUser->id !== 1) {
                $query->whereDoesntHave('roles', fn($q) => $q->where('name', 'superadmin'));
            } elseif ($authUser->hasRole('admin')) {
                $query->whereDoesntHave('roles', fn($q) => $q->whereIn('name', ['admin', 'superadmin']));
            }

            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('is_active', fn($row) => view('users::components.status-switch', ['status' => $row->is_active])->render())
                ->addColumn('action', function ($row) use ($authUser) {
                    return view('users::components.actions', compact('row', 'authUser'))->render();
                })
                ->rawColumns(['is_active', 'action'])
                ->make(true);
        }

        return view('users::index');
    }

    public function create()
    {
        $authUser = auth()->user();

        abort_if($authUser->hasRole('user'), 403);

        $roles = $authUser->hasRole('superadmin')
            ? Role::all()
            : Role::where('name', 'user')->get();

        breadcrumb()->reset()
            ->add('Dashboard', route('dashboard'))
            ->add('Users', route('users.index'))
            ->add('Create', route('users.create'));

        return view('users::create', compact('roles'));
    }

    public function store(Request $request)
    {
        $authUser = auth()->user();

        if ($authUser->hasRole('user')) {
            return redirect()->route('users.index')->with('error', 'You are not authorized to create users.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'is_active' => 'required|in:0,1',
            'role' => 'required|exists:roles,name',
        ]);

        if ($authUser->hasRole('admin') && $request->role !== 'user') {
            return redirect()->back()->with('error', 'Admins can only assign the user role.');
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'is_active' => $request->is_active,
        ]);

        $user->assignRole($request->role);

        return redirect()->route('users.index')->with('success', 'User created successfully!');
    }

    public function edit($id)
    {
        $authUser = auth()->user();
        $user = User::findOrFail($id);

        abort_if($authUser->hasRole('user'), 403);
        abort_if($user->hasRole('superadmin') && !$authUser->hasRole('superadmin'), 403);

        $roles = $authUser->hasRole('superadmin')
            ? Role::all()
            : Role::where('name', 'user')->get();

        return view('users::edit', compact('user', 'roles'));
    }

    public function update(Request $request, $id)
    {
        $authUser = auth()->user();
        $user = User::findOrFail($id);

        abort_if($authUser->hasRole('user'), 403);
        abort_if($user->hasRole('superadmin') && !$authUser->hasRole('superadmin'), 403);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => "required|email|unique:users,email,{$id}",
            'password' => 'nullable|string|min:6|confirmed',
            'is_active' => 'required|in:0,1',
            'role' => 'required|exists:roles,name',
        ]);

        if ($authUser->hasRole('admin') && $request->role !== 'user') {
            return redirect()->back()->with('error', 'Admins can only assign the user role.');
        }

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'is_active' => $request->is_active,
            'password' => $request->password ? Hash::make($request->password) : $user->password,
        ]);

        $user->syncRoles([$request->role]);

        return redirect()->route('users.index')->with('success', 'User updated successfully!');
    }

    public function destroy($id)
    {
        $authUser = auth()->user();
        $userToDelete = User::findOrFail($id);

        if ($authUser->hasRole('user') || $userToDelete->id === 1) {
            return redirect()->route('users.index')->with('error', 'You are not authorized to delete this user.');
        }

        $authIsSuperadmin = $authUser->hasRole('superadmin');
        $authIsAdmin = $authUser->hasRole('admin');
        $targetIsSuperadmin = $userToDelete->hasRole('superadmin');
        $targetIsAdmin = $userToDelete->hasRole('admin');

        if ($authIsSuperadmin && $authUser->id === 1) {
            $userToDelete->delete();
            return back()->with('success', 'User deleted successfully.');
        }

        if ($authIsSuperadmin && !$targetIsSuperadmin) {
            $userToDelete->delete();
            return back()->with('success', 'User deleted successfully.');
        }

        if ($authIsAdmin && !$targetIsAdmin && !$targetIsSuperadmin) {
            $userToDelete->delete();
            return back()->with('success', 'User deleted successfully.');
        }

        return back()->with('error', 'You are not authorized to delete this user.');
    }
}
