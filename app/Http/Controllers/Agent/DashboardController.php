<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\ScanLog;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $events = $user->assignedEvents()->with('organisateur')->get();

        $stats = [
            'events_assigned' => $events->count(),
            'scans_today' => ScanLog::where('scanned_by', $user->id)
                ->whereDate('scanned_at', today())
                ->count(),
            'scans_total' => ScanLog::where('scanned_by', $user->id)->count(),
        ];

        return view('agent.dashboard', compact('events', 'stats'));
    }

    public function events()
    {
        $user = auth()->user();
        $events = $user->assignedEvents()
            ->with('organisateur')
            ->withCount('guests')
            ->orderBy('date_start')
            ->get();

        return view('agent.events.index', compact('events'));
    }

    public function guestList(Event $event)
    {
        $user = auth()->user();
        if (!$event->staff()->where('users.id', $user->id)->exists()) {
            abort(403);
        }

        $guests = $event->guests()->with('ticket')->orderBy('name')->get();
        return view('agent.guests', compact('event', 'guests'));
    }
}
