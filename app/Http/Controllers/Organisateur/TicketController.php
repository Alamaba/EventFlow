<?php

namespace App\Http\Controllers\Organisateur;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Ticket;
use Barryvdh\DomPDF\Facade\Pdf;

class TicketController extends Controller
{
    public function index(Event $event)
    {
        if ($event->organisateur_id !== auth()->id()) abort(403);
        $tickets = $event->tickets()->with('guest')->latest()->paginate(20);
        return view('organisateur.tickets.index', compact('event', 'tickets'));
    }

    public function generateAll(Event $event)
    {
        if ($event->organisateur_id !== auth()->id()) abort(403);

        $guests = $event->guests()->doesntHave('ticket')->get();
        foreach ($guests as $guest) {
            $ticket = Ticket::create(['event_id' => $event->id, 'guest_id' => $guest->id]);
            $ticket->generateQrCode();
        }

        $existing = $event->tickets()->whereNull('qr_code_path')->get();
        foreach ($existing as $ticket) {
            $ticket->generateQrCode();
        }

        return back()->with('success', 'Tickets et QR codes générés pour tous les invités.');
    }

    public function download(Ticket $ticket)
    {
        if ($ticket->event->organisateur_id !== auth()->id()) abort(403);
        $ticket->load(['event', 'guest']);

        $pdf = Pdf::loadView('pdf.ticket', compact('ticket'));
        return $pdf->download('ticket-' . $ticket->uuid . '.pdf');
    }
}
