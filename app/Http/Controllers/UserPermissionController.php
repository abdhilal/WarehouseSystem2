<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class UserPermissionController extends Controller
{
    public function manage(Request $request)
    {
        $users = User::orderBy('name')->get();
        $selectedUserId = $request->query('user');
        $selectedUser = $selectedUserId ? User::find($selectedUserId) : null;

        $permissions = Permission::orderBy('group_name')->orderBy('name')->get();
        $direct = [];
        $viaRoles = [];
        if ($selectedUser) {
            $direct = $selectedUser->getDirectPermissions()->pluck('name')->all();
            $viaRoles = $selectedUser->getPermissionsViaRoles()->pluck('name')->all();
        }

        return view('pages.representatives.partials.manage', compact('users', 'selectedUser', 'permissions', 'direct', 'viaRoles'));
    }

    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'permissions' => ['array'],
            'permissions.*' => ['string'],
        ]);

        $user->syncPermissions($data['permissions'] ?? []);

        return redirect()->route('users.permissions.manage', ['user' => $user->id])
            ->with('success', __('Permissions updated successfully.'));
    }
}
