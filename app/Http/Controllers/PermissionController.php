<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
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
        if (!$this->user->hasPermissionTo('permission.view')) {
            return abort(403, 'Unauthorized action.');
        }

        $search = $request->get('search', '');

        $permissions = Permission::query()
            ->when($search, function ($query, $search) {
                $query->where('name', 'like', "%{$search}%");
            })
            ->orderBy('id', 'desc')
            ->paginate($this->paginate);

        // append old filter
        $permissions->appends(request()->query());

        return Inertia::render('Permission/Index', [
            'permissions' => $permissions,
            'total_permissions' => Permission::count(),
            'filters' => $request->all(['search']),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (!$this->user->hasPermissionTo('permission.create')) {
            return abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'name' => 'required|string|max:150|unique:permissions,name',
            'guard_name' => 'required|string|max:15',
        ]);

        try {
            Permission::create($request->all());

            return back()->with('success', 'Permission created successfully.');
        } catch (\Throwable $th) {
            return back()->with('error', 'Something went wrong in creating permission.');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Permission $permission)
    {
        if (!$this->user->hasPermissionTo('permission.edit')) {
            return abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'name' => 'required|string|max:150|unique:permissions,name,' . $permission->id,
            'guard_name' => 'required|string|max:15',
        ]);

        try {
            $permission->update($request->all());

            return back()->with('success', 'Permission updated successfully.');
        } catch (\Throwable $th) {
            return back()->with('error', 'Something went wrong in updating permission.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Permission $permission)
    {
        if (!$this->user->hasPermissionTo('permission.delete')) {
            return abort(403, 'Unauthorized action.');
        }

        try {
            $permission->delete();

            return back()->with('success', 'Permission deleted successfully.');
        } catch (\Throwable $th) {
            return back()->with('error', 'Something went wrong in deleting permission.');
        }
    }
}
