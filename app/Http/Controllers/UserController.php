<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserController extends Controller
{
    public function index()
    {
        $users = User::paginate();
        $roles = Role::all();
        return view('users.index', compact('users','roles'));
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

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|string|exists:roles,name',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $user->assignRole($request->role);

        return redirect()->route('users.index')->with('success', 'Usuario creado correctamente.');
    }
    public function destroy($userId)
    {
        $user = User::findOrFail($userId);
        $user->delete();

        return redirect()->route('users.index')->with('success', 'Usuario eliminado correctamente.');
    }
    public function resetPassword(Request $request, $userId)
    {
        $user = User::findOrFail($userId);
        $newPassword = Str::random(10);
        $user->password = Hash::make($newPassword);
        $user->save();
    
        return response()->json(['new_password' => $newPassword]);
    }
    

}
