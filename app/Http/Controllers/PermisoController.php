<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Vista;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PermisoController extends Controller
{
   public function index(Request $request)
{
    $roleId = $request->id_role;

    return Inertia::render('Permisos/Index', [
        'roles' => Role::all(),
        'vistas' => Vista::all(),
        'selectedRole' => $roleId,
        'selectedPermissions' => $roleId
            ? Role::find($roleId)?->vistas()->pluck('id_vista')
            : [],
    ]);
}
    public function getPermissions(Role $role)
{
    return response()->json(
        $role->vistas()->pluck('id_vista')
    );
}

    public function update(Request $request)
    {
        $request->validate([
            'id_role' => 'required|exists:roles,id_role',
            'vistas' => 'array',
        ]);

        $role = Role::findOrFail($request->id_role);

        $role->vistas()->sync($request->vistas ?? []);

        return back()->with('success', 'Permisos actualizados.');
    }
}