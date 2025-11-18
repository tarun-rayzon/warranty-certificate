<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Inertia\Inertia;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    //
    private $user;

    private $paginate;

    public function __construct(Request $request)
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            $this->user = $request->user(); // This will be executed after the 'auth' middleware

            return $next($request);
        });

        $this->paginate = config('app.paginate');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($this->user->hasPermissionTo('role.view')) {
            $search = $request->get('search', '');

            $roles = Role::with('permissions')
                ->when($search, function ($query, $search) {
                    $query->where('name', 'like', "%{$search}%")
                        ->orWhereHas('permissions', function ($query) use ($search) {
                            $query->where('name', 'like', "%{$search}%");
                        });
                })
                ->paginate($this->paginate);

            // append old filter
            $roles->appends(request()->query());

            return Inertia::render('Role/index', [
                'roles' => $roles,
                'permissions' => Permission::all(),
                'total_roles' => Role::count(),
                'filters' => $request->all(['search']),
            ]);
        } else {
            return abort(403, 'Unauthorized action.');
        }
    }

    public function store(Request $request)
    {
        if ($this->user->hasPermissionTo('role.create')) {
            $request->validate([
                'name' => 'required|string|max:255|unique:roles',
                'permissions' => 'required|array',
                'permissions.*' => 'exists:permissions,name',
            ]);

            try {
                $role = Role::create(['name' => $request->name, 'guard_name' => 'web']);
                $role->syncPermissions($request->permissions);

                return back()->with('success', 'Role created successfully.');
            } catch (\Throwable $th) {
                return back()->with('error', 'Something went wrong in creating role.');
            }
        } else {
            return abort(403, 'Unauthorized action.');
        }
    }

    public function update(Request $request, Role $role)
    {
        if ($this->user->hasPermissionTo('role.edit')) {
            $request->validate([
                'name' => 'required|string|max:255|unique:roles,name,' . $role->id,
                'permissions' => 'required|array',
                'permissions.*' => 'exists:permissions,name',
            ]);

            try {
                $role->update(['name' => $request->name]);
                $role->syncPermissions($request->permissions);

                return back()->with('success', 'Role updated successfully.');
            } catch (\Throwable $th) {
                return back()->with('error', 'Something went wrong in updating role.');
            }
        } else {
            return abort(403, 'Unauthorized action.');
        }
    }

    public function destroy(string $id)
    {
        if ($this->user->hasPermissionTo('role.delete')) {
            $role = Role::find($id);
            $role->permissions()->detach();
            $role->delete();

            return back()->with('success', 'Role deleted successfully.');
        } else {
            return abort(403, 'Unauthorized action.');
        }
    }
}
