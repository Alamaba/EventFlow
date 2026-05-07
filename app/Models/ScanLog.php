<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ScanLog extends Model
{
    protected $fillable = [
        'ticket_id', 'event_id', 'scanned_by',
        'result', 'ip_address', 'scanned_at',
    ];

    protected function casts(): array
    {
        return ['scanned_at' => 'datetime'];
    }

    public function ticket() { return $this->belongsTo(Ticket::class); }
    public function event() { return $this->belongsTo(Event::class); }
    public function agent() { return $this->belongsTo(User::class, 'scanned_by'); }
}
