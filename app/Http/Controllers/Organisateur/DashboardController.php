<?php

namespace App\Http\Controllers\Organisateur;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Ticket;
use App\Models\Payment;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $events = Event::forOrganisateur($user->id)->withCount('guests', 'tickets')->latest()->get();

        $stats = [
            'events_total' => $events->count(),
            'events_publie' => $events->where('status', 'publie')->count(),
            'guests_total' => $events->sum('guests_count'),
            'tickets_valides' => Ticket::whereIn('event_id', $events->pluck('id'))->where('status', 'valide')->count(),
            'revenus' => Payment::whereIn('event_id', $events->pluck('id'))->where('status', 'paye')->sum('amount'),
        ];

        $upcomingEvents = Event::forOrganisateur($user->id)
            ->where('date_start', '>=', now())
            ->where('status', 'publie')
            ->orderBy('date_start')
            ->take(5)
            ->get();

        return view('organisateur.dashboard', compact('stats', 'events', 'upcomingEvents'));
    }
}
