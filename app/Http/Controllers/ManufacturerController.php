<?php

namespace App\Http\Controllers;

use App\Models\Manufacturer;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ManufacturerController extends Controller
{
    public function index()
    {
        return Inertia::render('Manufacters/Index', [
            'manufacturers' => Manufacturer::orderBy('id', 'desc')->get()
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:manufacturers,name',
        ]);

        Manufacturer::create($validated);
        return redirect()->back();
    }

    public function destroy(Manufacturer $manufacturer)
    {
        $manufacturer->delete();
        return redirect()->back();
    }
}