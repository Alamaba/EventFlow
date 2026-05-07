<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Ticket;
use App\Models\ScanLog;
use Illuminate\Http\Request;

class ScanController extends Controller
{
    public function index(Event $event)
    {
        $user = auth()->user();
        if (!$event->staff()->where('users.id', $user->id)->exists()) {
            abort(403);
        }
        return view('agent.scan', compact('event'));
    }

    public function scan(Request $request)
    {
        $request->validate([
            'uuid' => 'required|string',
            'event_id' => 'nullable|exists:events,id',
        ]);

        $user = auth()->user();
        $raw  = $request->uuid;
        // Le QR code contient l'URL complète — on extrait le dernier segment
        if (filter_var($raw, FILTER_VALIDATE_URL)) {
            $raw = basename(parse_url($raw, PHP_URL_PATH));
        }
        $ticket = Ticket::with(['event', 'guest'])->where('uuid', $raw)->first();

        if (!$ticket) {
            return response()->json([
                'success' => false,
                'result' => 'invalid',
                'message' => 'QR Code invalide ou introuvable.',
                'color' => 'red',
            ]);
        }

        if ($ticket->status === 'annule') {
            $this->logScan($ticket, $user->id, 'cancelled', $request->ip());
            return response()->json([
                'success' => false,
                'result' => 'cancelled',
                'message' => 'Ce ticket a été annulé.',
                'color' => 'orange',
            ]);
        }

        if ($ticket->status === 'valide') {
            $this->logScan($ticket, $user->id, 'already_used', $request->ip());
            return response()->json([
                'success' => false,
                'result' => 'already_used',
                'message' => 'Ticket déjà utilisé le ' . $ticket->validated_at?->format('d/m/Y H:i'),
                'color' => 'orange',
                'guest' => $ticket->guest->name,
                'event' => $ticket->event->title,
            ]);
        }

        // Valider le ticket
        $ticket->update([
            'status' => 'valide',
            'validated_at' => now(),
            'validated_by' => $user->id,
            'entry_time' => now()->format('H:i'),
        ]);

        $ticket->guest->update(['status' => 'present']);
        $this->logScan($ticket, $user->id, 'success', $request->ip());

        return response()->json([
            'success' => true,
            'result' => 'success',
            'message' => 'Bienvenue ' . $ticket->guest->name . ' !',
            'color' => 'green',
            'guest' => $ticket->guest->name,
            'event' => $ticket->event->title,
            'entry_time' => now()->format('H:i'),
        ]);
    }

    private function logScan(Ticket $ticket, int $agentId, string $result, ?string $ip): void
    {
        ScanLog::create([
            'ticket_id' => $ticket->id,
            'event_id' => $ticket->event_id,
            'scanned_by' => $agentId,
            'result' => $result,
            'ip_address' => $ip,
            'scanned_at' => now(),
        ]);
    }
}
