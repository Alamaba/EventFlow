<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Guest extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id', 'name', 'email', 'phone', 'status',
        'note', 'invitation_sent', 'invitation_sent_at',
    ];

    protected function casts(): array
    {
        return [
            'invitation_sent' => 'boolean',
            'invitation_sent_at' => 'datetime',
        ];
    }

    public function event() { return $this->belongsTo(Event::class); }
    public function ticket() { return $this->hasOne(Ticket::class); }
    public function payment() { return $this->hasOne(Payment::class); }
}
