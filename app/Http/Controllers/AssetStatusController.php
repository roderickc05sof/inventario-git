<?php

namespace App\Http\Controllers;

use App\Models\AssetStatus;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AssetStatusController extends Controller
{
    public function index()
    {
        return Inertia::render('AssetStatuses/Index', [
            'statuses' => AssetStatus::orderBy('id', 'desc')->get()
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:50|unique:asset_statuses,name',
        ]);

        AssetStatus::create($validated);
        return redirect()->back();
    }

    public function destroy(AssetStatus $assetStatus)
    {
        $assetStatus->delete();
        return redirect()->back();
    }
}