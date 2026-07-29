<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\AssetStatus;
use App\Models\Asset;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AssignmentController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;

        $assignments = Assignment::with(['asset', 'user'])
            ->when($search, function ($query) use ($search) {
                $query->whereHas('user', function ($q) use ($search) {
                    $q->where('name', 'ilike', "%{$search}%");
                })
                ->orWhereHas('asset', function ($q) use ($search) {
                    $q->where('name', 'ilike', "%{$search}%");
                });
            })
            ->paginate(10)
            ->withQueryString();

        return Inertia::render('Assignments/Index', [
            'assignments' => $assignments,
            'search' => $search,
        ]);
    }

 public function create()
    {
        return Inertia::render('Assignments/Create', [
            'assets' => Asset::query()->where('status_id', 1)->get(), 
            'users' => User::all(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'asset_id' => 'required|exists:assets,id',
            'user_id' => 'required|exists:users,id',
            'assigned_at' => 'required|date',
            'condition_on_delivery' => 'required|string|max:255',
            'signature' => 'nullable|string',
        ]);

        Assignment::create($validated);

        return redirect()->route('assignments.index')
            ->with('success', 'Asignación creada correctamente.');
    }

    public function edit(Assignment $assignment)
    {
        return Inertia::render('Assignments/Edit', [
            'assignment' => $assignment,
            'assets' => Asset::all(),
            'users' => User::all(),
        ]);
    }

    public function update(Request $request, Assignment $assignment)
    {
        $validated = $request->validate([
            'asset_id' => 'required|exists:assets,id',
            'user_id' => 'required|exists:users,id',
            'assigned_at' => 'required|date',
            'returned_at' => 'nullable|date|after_or_equal:assigned_at',
            'condition_on_delivery' => 'required|string|max:255',
            'condition_on_return' => 'nullable|string|max:255',
            'signature' => 'nullable|string',
        ]);

        $assignment->update($validated);

        return redirect()->route('assignments.index')
            ->with('success', 'Asignación actualizada correctamente.');
    }

    public function destroy(Assignment $assignment)
    {
        $assignment->delete();

        return redirect()->route('assignments.index')
            ->with('success', 'Asignación eliminada correctamente.');
    }
}