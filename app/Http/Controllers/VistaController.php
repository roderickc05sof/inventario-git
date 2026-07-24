<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Vista;

class VistaController extends Controller

{
    /**
     * Display a listing of the resource.
     */
public function index(Request $request)
    {
        $search = $request->input('search', '');

        $query = Vista::query();

        if ($search) {
            $query->where('name', 'ilike', "%{$search}%");
        }

        $vistas = $query
            ->paginate(10)
            ->withQueryString();

        return Inertia::render('Vista/Index', [
            'vistas' => $vistas,
            'search' => (string) $search,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
   public function create()
{
    return Inertia::render('Vista/Create');
}
    /**
     * Store a newly created resource in storage.
     */
public function store(Request $request)
{
    $validated = $request->validate([
        'name' => 'required|string|max:100|unique:vistas,name',
    ]);

    Vista::create($validated);

    return redirect()
        ->route('vistas.index')
        ->with('success', 'Vista creada correctamente.');
}

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
public function edit(Vista $vista)
{
    return Inertia::render('Vista/Edit', [
        'vista' => $vista,
    ]);
}

public function update(Request $request, Vista $vista)
{
    $validated = $request->validate([
        'name' => 'required|string|max:100|unique:vistas,name,'.$vista->id_vista.',id_vista',
    ]);

    $vista->update($validated);

    return redirect()
        ->route('vistas.index')
        ->with('success', 'Vista actualizada.');
}
    /**
     * Remove the specified resource from storage.
     */
   public function destroy(Vista $vista)
{
    $vista->delete();

    return redirect()
        ->route('vistas.index')
        ->with('success','Vista eliminada.');
}
}
