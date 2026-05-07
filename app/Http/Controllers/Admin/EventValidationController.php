<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;

class EventValidationController extends Controller
{
    public function index()
    {
        $events = Event::with('organisateur')
            ->withCount('guests', 'tickets')
            ->latest()
            ->paginate(15);
        return view('admin.events.index', compact('events'));
    }

    public function publish(Event $event)
    {
        $event->update(['status' => 'publie']);
        return back()->with('success', 'Événement publié.');
    }

    public function cancel(Event $event)
    {
        $event->update(['status' => 'annule']);
        return back()->with('success', 'Événement annulé.');
    }
}
