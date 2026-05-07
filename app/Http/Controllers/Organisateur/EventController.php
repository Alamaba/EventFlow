<?php

namespace App\Http\Controllers\Organisateur;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::forOrganisateur(auth()->id())
            ->withCount('guests', 'tickets')
            ->latest()
            ->paginate(12);
        return view('organisateur.events.index', compact('events'));
    }

    public function create()
    {
        return view('organisateur.events.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:mariage,ceremonie,conference,anniversaire,concert,autre',
            'date_start' => 'required|date|after:now',
            'date_end' => 'required|date|after:date_start',
            'venue' => 'required|string|max:255',
            'address' => 'nullable|string',
            'city' => 'nullable|string|max:100',
            'capacity' => 'required|integer|min:1',
            'cover_image' => 'nullable|image|max:2048',
            'is_paid' => 'boolean',
            'price' => 'nullable|numeric|min:0',
            'currency' => 'nullable|string|max:3',
        ]);

        if ($request->hasFile('cover_image')) {
            $validated['cover_image'] = $request->file('cover_image')->store('events/covers', 'public');
        }

        $validated['organisateur_id'] = auth()->id();
        $validated['is_paid'] = $request->boolean('is_paid');

        $event = Event::create($validated);

        return redirect()->route('organisateur.events.show', $event)
            ->with('success', 'Événement créé avec succès.');
    }

    public function show(Event $event)
    {
        $this->authorizeEvent($event);
        $event->load(['guests', 'tickets', 'staff']);
        $stats = [
            'guests_total' => $event->guests->count(),
            'guests_confirmes' => $event->guests->where('status', 'confirme')->count(),
            'guests_presents' => $event->guests->where('status', 'present')->count(),
            'tickets_valides' => $event->tickets->where('status', 'valide')->count(),
            'taux_presence' => $event->guests->count() > 0
                ? round($event->guests->where('status', 'present')->count() / $event->guests->count() * 100)
                : 0,
        ];
        return view('organisateur.events.show', compact('event', 'stats'));
    }

    public function edit(Event $event)
    {
        $this->authorizeEvent($event);
        return view('organisateur.events.edit', compact('event'));
    }

    public function update(Request $request, Event $event)
    {
        $this->authorizeEvent($event);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:mariage,ceremonie,conference,anniversaire,concert,autre',
            'date_start' => 'required|date',
            'date_end' => 'required|date|after:date_start',
            'venue' => 'required|string|max:255',
            'address' => 'nullable|string',
            'city' => 'nullable|string|max:100',
            'capacity' => 'required|integer|min:1',
            'cover_image' => 'nullable|image|max:2048',
            'is_paid' => 'boolean',
            'price' => 'nullable|numeric|min:0',
            'currency' => 'nullable|string|max:3',
        ]);

        if ($request->hasFile('cover_image')) {
            if ($event->cover_image) Storage::disk('public')->delete($event->cover_image);
            $validated['cover_image'] = $request->file('cover_image')->store('events/covers', 'public');
        }

        $validated['is_paid'] = $request->boolean('is_paid');
        $event->update($validated);

        return redirect()->route('organisateur.events.show', $event)
            ->with('success', 'Événement mis à jour.');
    }

    public function destroy(Event $event)
    {
        $this->authorizeEvent($event);
        if ($event->cover_image) Storage::disk('public')->delete($event->cover_image);
        $event->delete();
        return redirect()->route('organisateur.events.index')
            ->with('success', 'Événement supprimé.');
    }

    public function publish(Event $event)
    {
        $this->authorizeEvent($event);
        $event->update(['status' => 'publie']);
        return back()->with('success', 'Événement soumis pour validation.');
    }

    public function stats(Event $event)
    {
        $this->authorizeEvent($event);
        $event->load(['guests', 'tickets', 'scanLogs.agent']);
        return view('organisateur.events.stats', compact('event'));
    }

    private function authorizeEvent(Event $event): void
    {
        if ($event->organisateur_id !== auth()->id()) abort(403);
    }
}
