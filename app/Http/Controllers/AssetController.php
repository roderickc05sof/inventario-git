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
public function index()
{
    $assets = Asset::with([
        'category',
        'manufacturer',
        'location',
        'status'
    ])->get();

    return Inertia::render('Assets/Index', [
        'assets' => $assets
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