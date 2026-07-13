<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use Illuminate\Http\Request;
use Inertia\Inertia;

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
}