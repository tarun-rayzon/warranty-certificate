<?php

namespace App\Http\Controllers;

use App\Actions\Fortify\PasswordValidationRules;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    use PasswordValidationRules;

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
        if (!$this->user->hasPermissionTo('user.view')) {
            return abort(403, 'Unauthorized action.');
        }

        // Filters
        $search = $request->get('search', '');

        // Sorting
        $sort = $request->get('sort', 'id');
        $sort_order = $request->get('order', 'desc');

        // User query
        $users = User::query()
            // ->whereDoesntHave('roles', fn($q) => $q->where('name', 'admin'))
            ->when($search, function ($query, $search) {
                $query->where(function ($query) use ($search) {
                    $query->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('mobile', 'like', "%{$search}%")
                        ->orWhere('employee_code', 'like', "%{$search}%")
                        ->orWhereHas('roles', fn($q) => $q->where('name', 'like', "%{$search}%"));
                });
            })
            ->orderBy($sort, $sort_order)
            ->with(['roles:name'])
            ->paginate($this->paginate);


        $users->appends(request()->query());

        // User count summary
        $data['users'] = User::query()
            ->selectRaw('
            COUNT(*) as total
        ')->get();

        return Inertia::render('User/index', [
            'users' => $users,
            'roles' => Role::all(),
            'data' => $data,
            'filters' => request()->only(['search'])
        ]);
    }

    /**
     * store a listing of the resource.
     */
    public function store(Request $request)
    {
        if (!$this->user->hasPermissionTo('user.create')) {
            return abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'mobile' => 'required|string|min:10|max:10|unique:users,mobile',
            'role' => 'required|array',
            'role.*' => 'exists:roles,name',
            'password' => $this->passwordRules(),
        ]);

        try {
            // create user
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'mobile' => $request->mobile,
                'password' => Hash::make($request->password),
            ]);

            // assign roles
            $user->syncRoles($request->role);

            return back()->with('success', 'User created successfully.');
        } catch (\Throwable $th) {
            return back()->with('error', 'Something went wrong in creating user.');
        }
    }

    public function update(Request $request, int $id)
    {
        if (!$this->user->hasPermissionTo('user.edit')) {
            return abort(403, 'Unauthorized action.');
        }

        // Validate the request
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'mobile' => 'required|string|min:10|max:10|unique:users,mobile,' . $id,
            'role' => 'required|array',
            'role.*' => 'exists:roles,name'
        ]);

        try {
            // Find the user
            $user = User::findOrFail($id);

            // Update user details
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'mobile' => $request->mobile,
            ]);

            // Update roles (Detach old roles and assign new role)
            $user->syncRoles($request->role);

            return back()->with('success', 'User updated successfully.');
        } catch (\Throwable $th) {
            return back()->with('error', 'Something went wrong in updating user.');
        }
    }

    /**
     * Update user password
     */
    public function updatePassword(Request $request, int $id)
    {
        if (!$this->user->hasPermissionTo('user.edit')) {
            return abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'password' => 'required|confirmed',
        ]);

        try {
            $user = User::findOrFail($id);

            if (!$user) {
                return back()->with('error', 'User not found.');
            }

            $user->update([
                'password' => Hash::make($request->password),
            ]);

            return back()->with('success', 'Password updated successfully.');
        } catch (\Throwable $th) {
            return back()->with('error', 'Something went wrong in updating password.');
        }
    }

    /**
     * Delete all sessions from seession table
     */
    public function sessionDestroy(Request $request, int $id)
    {
        if (!$this->user->hasPermissionTo('user.edit')) {
            return abort(403, 'Unauthorized action.');
        }

        try {
            $user = User::findOrFail($id);

            if (!$user) {
                return back()->with('error', 'User not found.');
            }

            DB::table('sessions')->where('user_id', $user->id)->delete();

            return back()->with('success', 'Sessions deleted successfully.');
        } catch (\Throwable $th) {
            return back()->with('error', 'Something went wrong in deleting sessions.');
        }
    }
}
