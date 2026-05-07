<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'event_id', 'guest_id', 'amount', 'currency',
        'payment_method', 'stripe_payment_intent', 'transaction_id',
        'status', 'paid_at',
    ];

    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
            'paid_at' => 'datetime',
        ];
    }

    public function event() { return $this->belongsTo(Event::class); }
    public function guest() { return $this->belongsTo(Guest::class); }
}
