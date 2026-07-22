<?php

namespace App\Http\Controllers;

use App\Models\Component;
use App\Models\Asset;
use App\Models\ComponentType;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ComponentController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;

        $components = Component::with([
            'asset',
            'componentType',
        ])
        ->when($search, function ($query) use ($search) {
    $query->where(function ($q) use ($search) {

        $q->where('serial_number', 'ilike', "%{$search}%")
          ->orWhere('brand', 'ilike', "%{$search}%")

          ->orWhereHas('asset', function ($q) use ($search) {
              $q->where('name', 'ilike', "%{$search}%");
          })

          ->orWhereHas('componentType', function ($q) use ($search) {
              $q->where('name', 'ilike', "%{$search}%");
          });

    });
})
        ->paginate(10)
        ->withQueryString();

        return Inertia::render('Components/Index', [
            'components' => $components,
            'search' => $search,
        ]);
    }

    public function create()
    {
        return Inertia::render('Components/Create', [
            'assets' => Asset::all(),
            'componentTypes' => ComponentType::all(),
        ]);
    }

public function store(Request $request)
{
    $validated = $request->validate([
        'serial_number' => 'nullable|string|max:255',
        'asset_id' => 'required|exists:assets,id',
        'component_type_id' => 'required|exists:component_types,id',
        'brand' => 'nullable|string|max:255',
        'specifications' => 'nullable|string',
    ]);

    $validated['specifications'] = $validated['specifications']
        ? json_decode($validated['specifications'], true)
        : null;

    Component::create($validated);

    return redirect()->route('components.index')
        ->with('success', 'Componente creado correctamente.');
}
   public function edit(Component $component)
{
    return Inertia::render('Components/Edit', [
        'component' => $component,
        'assets' => Asset::all(),
        'componentTypes' => ComponentType::all(),
    ]);
}

    public function update(Request $request, Component $component)
{
 $validated = $request->validate([
    'serial_number' => 'nullable|string|max:255',
    'asset_id' => 'required|exists:assets,id',
    'component_type_id' => 'required|exists:component_types,id',
    'brand' => 'nullable|string|max:255',
    'specifications' => 'nullable|string',
]);

$validated['specifications'] = $validated['specifications']
    ? json_decode($validated['specifications'], true)
    : null;

$component->update($validated);

return redirect()->route('components.index')
    ->with('success', 'Componente actualizado correctamente.');
}

    public function destroy(Component $component)
    {
        $component->delete();

        return redirect()->route('components.index')
            ->with('success', 'Componente eliminado correctamente.');
    }
}