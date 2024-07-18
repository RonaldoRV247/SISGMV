<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserController extends Controller
{
    public function index()
    {
        $users = User::paginate();
        return view('users.index', compact('users'));
    }

    public function edit($userId)
    {
        $user = User::findOrFail($userId);
        $roles = Role::all();
        return view('users.edit', compact('user', 'roles'));
    }

    public function updateRoles(Request $request, $userId)
    {
        // Validar la solicitud
        $request->validate([
            'roles' => 'required|array',
            'roles.*' => 'exists:roles,name'
        ]);

        // Encontrar al usuario por su ID
        $user = User::findOrFail($userId);

        // Sincronizar roles
        $user->syncRoles($request->roles);

        return redirect()->back()->with('success', 'Roles actualizados correctamente.');
    }
}
