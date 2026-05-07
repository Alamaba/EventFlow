<?php

namespace App\Http\Controllers\Organisateur;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Guest;
use App\Models\Ticket;
use App\Mail\InvitationMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class GuestController extends Controller
{
    public function index(Event $event)
    {
        $this->authorizeEvent($event);
        $guests = $event->guests()->with('ticket')->latest()->paginate(20);
        return view('organisateur.guests.index', compact('event', 'guests'));
    }

    public function create(Event $event)
    {
        $this->authorizeEvent($event);
        return view('organisateur.guests.create', compact('event'));
    }

    public function store(Request $request, Event $event)
    {
        $this->authorizeEvent($event);
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email',
            'phone' => 'nullable|string|max:20',
            'note' => 'nullable|string',
        ]);

        $guest = $event->guests()->create($validated);

        $ticket = Ticket::create([
            'event_id' => $event->id,
            'guest_id' => $guest->id,
        ]);
        $ticket->generateQrCode();

        return redirect()->route('organisateur.events.guests.index', $event)
            ->with('success', 'Invité ajouté et ticket généré.');
    }

    public function show(Guest $guest)
    {
        return view('organisateur.guests.show', compact('guest'));
    }

    public function edit(Guest $guest)
    {
        return view('organisateur.guests.edit', compact('guest'));
    }

    public function update(Request $request, Guest $guest)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email',
            'phone' => 'nullable|string|max:20',
            'status' => 'in:invite,confirme,annule,present',
            'note' => 'nullable|string',
        ]);
        $guest->update($validated);
        return back()->with('success', 'Invité mis à jour.');
    }

    public function destroy(Guest $guest)
    {
        $guest->delete();
        return back()->with('success', 'Invité supprimé.');
    }

    public function sendInvitation(Guest $guest)
    {
        if (!$guest->email) {
            return back()->with('error', "Cet invité n'a pas d'email.");
        }

        $ticket = $guest->ticket;
        if (!$ticket) {
            $ticket = Ticket::create(['event_id' => $guest->event_id, 'guest_id' => $guest->id]);
            $ticket->generateQrCode();
        }

        Mail::to($guest->email)->send(new InvitationMail($guest, $ticket));

        $guest->update(['invitation_sent' => true, 'invitation_sent_at' => now()]);
        return back()->with('success', 'Invitation envoyée à ' . $guest->name);
    }

    public function sendAllInvitations(Event $event)
    {
        $this->authorizeEvent($event);
        $guests = $event->guests()->whereNotNull('email')->where('invitation_sent', false)->get();

        foreach ($guests as $guest) {
            $ticket = $guest->ticket ?? Ticket::create(['event_id' => $event->id, 'guest_id' => $guest->id]);
            if (!$ticket->qr_code_path) $ticket->generateQrCode();
            Mail::to($guest->email)->queue(new InvitationMail($guest, $ticket));
            $guest->update(['invitation_sent' => true, 'invitation_sent_at' => now()]);
        }

        return back()->with('success', $guests->count() . ' invitations envoyées.');
    }

    public function import(Request $request)
    {
        return back()->with('info', 'Import CSV disponible bientôt.');
    }

    private function authorizeEvent(Event $event): void
    {
        if ($event->organisateur_id !== auth()->id()) abort(403);
    }
}
