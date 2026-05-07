<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class OrganisateurController extends Controller
{
    public function index()
    {
        $organisateurs = User::where('role', 'organisateur')
            ->withCount('events')
            ->latest()
            ->paginate(15);
        return view('admin.organisateurs.index', compact('organisateurs'));
    }

    public function create()
    {
        return view('admin.organisateurs.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|confirmed',
            'phone' => 'nullable|string|max:20',
        ]);

        User::create([
            ...$validated,
            'password' => Hash::make($validated['password']),
            'role' => 'organisateur',
        ]);

        return redirect()->route('admin.organisateurs.index')
            ->with('success', 'Organisateur créé avec succès.');
    }

    public function show(User $organisateur)
    {
        $organisateur->load(['events' => fn($q) => $q->withCount('guests', 'tickets')->latest()]);
        return view('admin.organisateurs.show', compact('organisateur'));
    }

    public function edit(User $organisateur)
    {
        return view('admin.organisateurs.edit', compact('organisateur'));
    }

    public function update(Request $request, User $organisateur)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $organisateur->id,
            'phone' => 'nullable|string|max:20',
            'password' => 'nullable|min:8|confirmed',
        ]);

        if (empty($validated['password'])) {
            unset($validated['password']);
        } else {
            $validated['password'] = Hash::make($validated['password']);
        }

        $organisateur->update($validated);
        return redirect()->route('admin.organisateurs.index')
            ->with('success', 'Organisateur mis à jour.');
    }

    public function destroy(User $organisateur)
    {
        $organisateur->delete();
        return redirect()->route('admin.organisateurs.index')
            ->with('success', 'Organisateur supprimé.');
    }

    public function toggleStatus(User $organisateur)
    {
        $organisateur->update(['is_active' => !$organisateur->is_active]);
        return back()->with('success', 'Statut mis à jour.');
    }
}
