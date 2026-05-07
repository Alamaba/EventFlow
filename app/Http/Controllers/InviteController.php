<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class InviteController extends Controller
{
    public function show(string $uuid)
    {
        $ticket = Ticket::with(['event', 'guest'])->where('uuid', $uuid)->firstOrFail();
        return view('invite.ticket', compact('ticket'));
    }

    public function rsvp(string $uuid, Request $request)
    {
        $ticket = Ticket::with(['guest'])->where('uuid', $uuid)->firstOrFail();
        $action = $request->input('action');

        if ($action === 'confirm') {
            $ticket->guest->update(['status' => 'confirme']);
            return back()->with('success', 'Votre présence a été confirmée !');
        }

        if ($action === 'decline') {
            $ticket->guest->update(['status' => 'annule']);
            $ticket->update(['status' => 'annule']);
            return back()->with('info', 'Votre participation a été annulée.');
        }

        return back();
    }

    public function download(string $uuid)
    {
        $ticket = Ticket::with(['event', 'guest'])->where('uuid', $uuid)->firstOrFail();
        $pdf = Pdf::loadView('pdf.ticket', compact('ticket'));
        return $pdf->download('ticket-' . $ticket->guest->name . '.pdf');
    }
}
