<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Category;
use App\Models\Manufacturer;
use App\Models\locations;
use App\Models\AssetStatus;

class AssetController extends Controller
{
public function index(Request $request)
{
    $search = $request->search;

    $assets = Asset::with([
        'category',
        'manufacturer',
        'location',
        'status'
    ])
    ->when($search, function ($query) use ($search) {

        $query->where('name', 'ilike', "%{$search}%")

        ->orWhere('serial_number', 'ilike', "%{$search}%")

        ->orWhere('inventory_tag', 'ilike', "%{$search}%")

        ->orWhere('model_number', 'ilike', "%{$search}%")

        ->orWhereHas('category', function ($q) use ($search) {
            $q->where('name', 'ilike', "%{$search}%");
        })

        ->orWhereHas('manufacturer', function ($q) use ($search) {
            $q->where('name', 'ilike', "%{$search}%");
        })

        ->orWhereHas('location', function ($q) use ($search) {
            $q->where('name', 'ilike', "%{$search}%");
        })

        ->orWhereHas('status', function ($q) use ($search) {
            $q->where('name', 'ilike', "%{$search}%");
        });

    })
    ->paginate(10)
     ->withQueryString();

    return Inertia::render('Assets/Index', [
        'assets' => $assets,
        'search' => $search,
    ]);
}

public function create(){
    return Inertia::render('Assets/Create',[
    "categories"=>Category::all(),
    'manufacturers' => Manufacturer::all(),
        'locations' => locations::all(),
        'statuses' => AssetStatus::all(),
        ]);
}

public function edit(Asset $asset)
{
    return Inertia::render('Assets/Edit', [
        'asset' => $asset,
        'categories' => Category::all(),
        'manufacturers' => Manufacturer::all(),
        'locations' => Locations::all(),
        'statuses' => AssetStatus::all(),
    ]);
}
 public function update(Request $request, Asset $asset)
    {
        $validated = $request->validate([
        'name' => 'required|string|max:255',
        'category_id' => 'required|exists:categories,id',
        'manufacturer_id' => 'required|exists:manufacturers,id',
        'location_id' => 'required|exists:locations,id',
        'status_id' => 'required|exists:asset_statuses,id',
        'model_number' => 'nullable|string|max:255',
        'serial_number' => 'nullable|string|max:255',
        'inventory_tag' => 'nullable|string|max:255',
        'purchase_date' => 'nullable|date',
        'cost' => 'nullable|numeric',
        'notes' => 'nullable|string',
    ]);

    $asset->update($validated);

    return redirect()->route('assets.index')
        ->with('success', 'Activo actualizado correctamente.');
    }

    // Eliminar un activo
   public function destroy(Asset $asset)
{
    $asset->delete();

    return redirect()->route('assets.index')
        ->with('success', 'Activo eliminado correctamente.');
}



public function store(Request $request)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'category_id' => 'required|exists:categories,id',
        'manufacturer_id' => 'required|exists:manufacturers,id',
        'location_id' => 'required|exists:locations,id',
        'status_id' => 'required|exists:asset_statuses,id',
        'model_number' => 'required|string|max:100',
        'serial_number' => 'required|string|max:100',
        'inventory_tag' => 'required|string|max:100',
        'purchase_date' => 'required|date',
        'cost' => 'required|numeric',
        'notes' => 'nullable|string',
    ]);

    

    Asset::create($validated);

    return redirect()->route('assets.index')
        ->with('success', 'Activo creado correctamente.');
}

}