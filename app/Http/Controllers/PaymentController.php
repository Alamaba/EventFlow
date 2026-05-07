<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Guest;
use App\Models\Payment;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\PaymentIntent;

class PaymentController extends Controller
{
    public function __construct()
    {
        Stripe::setApiKey(config('services.stripe.secret'));
    }

    public function checkout(Event $event)
    {
        return view('payment.checkout', compact('event'));
    }

    public function process(Request $request, Event $event)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'nullable|string|max:20',
        ]);

        $guest = $event->guests()->create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'status' => 'invite',
        ]);

        $intent = PaymentIntent::create([
            'amount' => (int)($event->price * 100),
            'currency' => strtolower($event->currency ?? 'djf'),
            'metadata' => [
                'event_id' => $event->id,
                'guest_id' => $guest->id,
            ],
        ]);

        Payment::create([
            'event_id' => $event->id,
            'guest_id' => $guest->id,
            'amount' => $event->price,
            'currency' => $event->currency,
            'payment_method' => 'stripe',
            'stripe_payment_intent' => $intent->id,
            'status' => 'en_attente',
        ]);

        return view('payment.stripe', compact('event', 'guest', 'intent'));
    }

    public function success()
    {
        return view('payment.success');
    }

    public function cancel()
    {
        return view('payment.cancel');
    }

    public function webhook(Request $request)
    {
        $payload = $request->getContent();
        $sig = $request->header('Stripe-Signature');

        try {
            $event = \Stripe\Webhook::constructEvent(
                $payload, $sig, config('services.stripe.webhook_secret')
            );
        } catch (\Exception $e) {
            return response('Webhook error', 400);
        }

        if ($event->type === 'payment_intent.succeeded') {
            $intent = $event->data->object;
            $payment = Payment::where('stripe_payment_intent', $intent->id)->first();
            if ($payment) {
                $payment->update(['status' => 'paye', 'paid_at' => now()]);
                $payment->guest->update(['status' => 'confirme']);
                $ticket = Ticket::create([
                    'event_id' => $payment->event_id,
                    'guest_id' => $payment->guest_id,
                ]);
                $ticket->generateQrCode();
            }
        }

        return response('OK', 200);
    }
}
