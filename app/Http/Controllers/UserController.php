<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

use App\Models\Role;
use App\Models\Vista;
class UserController extends Controller
{
    public function index(Request $request)
{
    $search = $request->search;

    $users = User::with('role')
        ->when($search, function ($query) use ($search) {
            $query
                ->where('name', 'ilike', "%{$search}%")
                ->orWhere('email', 'ilike', "%{$search}%")
                ->orWhereHas('role', function ($q) use ($search) {
                    $q->where('descripcion', 'ilike', "%{$search}%");
                });
        })
        ->paginate(10)
        ->withQueryString();

    return Inertia::render('Users/Index', [
        'users' => $users,
        'search' => $search,
    ]);
}

public function create()
{
    return Inertia::render('Users/Create', [
        'roles' => Role::all(),
    ]);
}
public function store(Request $request)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|confirmed|min:8',
        'id_role' => 'required|exists:roles,id_role',
    ]);

    User::create([
        'name' => $validated['name'],
        'email' => $validated['email'],
        'password' => Hash::make($validated['password']),
        'id_role' => $validated['id_role'],
    ]);

    return redirect()
        ->route('users.index')
        ->with('success', 'Usuario creado correctamente.');
}

public function edit(User $user)
{
    return Inertia::render('Users/Edit', [
        'user' => $user,
        'roles' => Role::all(),
    ]);
}

public function update(Request $request, User $user)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email,' . $user->id,
        'id_role' => 'required|exists:roles,id_role',
        'password' => 'nullable|confirmed|min:8',
    ]);

    $user->name = $validated['name'];
    $user->email = $validated['email'];
    $user->id_role = $validated['id_role'];

    if (!empty($validated['password'])) {
        $user->password = Hash::make($validated['password']);
    }

    $user->save();

    return redirect()
        ->route('users.index')
        ->with('success', 'Usuario actualizado correctamente.');
}

public function destroy(User $user)
{
    $user->delete();

    return redirect()
        ->route('users.index')
        ->with('success', 'Usuario eliminado correctamente.');
}

}
