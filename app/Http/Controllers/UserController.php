<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\User;
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
                    $q->where('name', 'ilike', "%{$search}%");
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
    return Inertia::render('Users/Create',[
        'roles' => Role::all(),
        'vistas' => Vista::all(),
    ]);
}

}
