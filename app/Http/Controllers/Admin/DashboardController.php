<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\User;
use App\Models\Ticket;
use App\Models\Payment;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'organisateurs' => User::where('role', 'organisateur')->count(),
            'agents' => User::where('role', 'agent')->count(),
            'events_total' => Event::count(),
            'events_publie' => Event::where('status', 'publie')->count(),
            'events_brouillon' => Event::where('status', 'brouillon')->count(),
            'tickets_total' => Ticket::count(),
            'tickets_valides' => Ticket::where('status', 'valide')->count(),
            'revenus' => Payment::where('status', 'paye')->sum('amount'),
        ];

        $recentEvents = Event::with('organisateur')->latest()->take(10)->get();
        $recentOrganisateurs = User::where('role', 'organisateur')->withCount('events')->latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recentEvents', 'recentOrganisateurs'));
    }
}
