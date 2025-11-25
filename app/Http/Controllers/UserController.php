<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\User;
use App\Models\Warehouse;
use Illuminate\Http\Request;
use App\Services\UserService;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\StoreUserRequest;
use App\Services\RepresentativeService;
use App\Http\Requests\UpdateUserRequest;
use Spatie\Permission\Models\Permission;
use App\Http\Requests\StoreRepresentativeRequest;
use App\Http\Requests\UpdateRepresentativeRequest;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;


class UserController extends Controller
{
    use AuthorizesRequests;
    protected $service;

    public function __construct(UserService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        $this->authorize('viewAny', User::class);
        $users = $this->service->getUsers($request);
        return view('pages.users.index', compact('users'));
    }

    public function create()
    {
        $this->authorize('create', User::class);
        $warehouses = Warehouse::orderBy('name')->get();
        $areas = Area::orderBy('name')->get();
        return view('pages.users.partials.create', compact('warehouses', 'areas'));
    }

    public function store(StoreUserRequest $request)
    {
        $this->authorize('create', User::class);
        $data = $request->validated();
        $data['password'] = Hash::make($data['password']);
        $user = $this->service->createUser($data);
        $user->assignRole('User');
        return redirect()->route('users.index')
            ->with('success', __('User created successfully.'));
    }

    public function show(User $user)
    {
        $this->authorize('view', $user);
        $user->load(['warehouse']);
        return view('pages.users.partials.show', compact('user'));
    }

    public function edit(User $user)
    {
        $warehouses = Warehouse::orderBy('name')->get();
        $areas = Area::orderBy('name')->get();
        return view('pages.users.partials.edit', compact('user', 'warehouses', 'areas'));
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $data = $request->validated();
        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }
        $this->service->updateUser($user, $data);
        return redirect()->route('users.index')
            ->with('success', __('User updated successfully.'));
    }

    public function destroy(User $user)
    {
        $this->authorize('delete', $user);
        $this->service->deleteUser($user);
        return redirect()->back()
            ->with('success', __('User deleted successfully.'));
    }

    public function impersonate(User $user)
    {
        $this->authorize('impersonate', $user);
        if (auth()->id() === $user->id) {
            return redirect()->route('dashboard');
        }
        session(['impersonator_id' => auth()->id()]);
        auth()->login($user);
        return redirect()->route('dashboard')
            ->with('success', __('Logged in as :name', ['name' => $user->name]));
    }



    public function managePermissions(Request $request)
    {
        $this->authorize('managePermissions', User::class);
        $users = User::orderBy('name')->get();
        $selectedUserId = $request->query('user');
        $selectedUser = $selectedUserId ? User::find($selectedUserId) : null;

        $permissions = Permission::orderBy('group_name')->orderBy('name')->get();
        $roles = Role::orderBy('name')->get();
        $direct = [];
        $viaRoles = [];
        $selectedRoles = [];
        if ($selectedUser) {
            $direct = $selectedUser->getDirectPermissions()->pluck('name')->all();
            $viaRoles = $selectedUser->getPermissionsViaRoles()->pluck('name')->all();
            $selectedRoles = $selectedUser->roles->pluck('name')->all();
        }

        return view('pages.users.partials.manage', compact('users', 'selectedUser', 'permissions', 'roles', 'direct', 'viaRoles', 'selectedRoles'));
    }

    public function updatePermissions(Request $request, User $user)
    {
        $this->authorize('managePermissions', User::class);
        $data = $request->validate([
            'permissions' => ['array'],
            'permissions.*' => ['string'],
            'roles' => ['array'],
            'roles.*' => ['string'],
        ]);

        $user->syncRoles($data['roles'] ?? []);
        $user->syncPermissions($data['permissions'] ?? []);

        return redirect()->route('users.permissions.manage', ['user' => $user->id])
            ->with('success', __('Permissions updated successfully.'));
    }
}
