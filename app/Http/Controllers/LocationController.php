<?php

namespace App\Http\Controllers;

use App\Models\locations;
use Illuminate\Http\Request;
use Inertia\Inertia;

class LocationController extends Controller
{
    public function index()
    {
        return Inertia::render('Locations/Index', [
            'locations' => locations::orderBy('id', 'desc')->get()
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:locations,name',
        ]);

        locations::create($validated);

        return redirect()->back();
    }

    public function destroy(locations $location)
    {
        $location->delete();
        
        return redirect()->back();
    }
}