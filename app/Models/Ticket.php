<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid', 'event_id', 'guest_id', 'qr_code_path',
        'status', 'validated_at', 'validated_by', 'entry_time',
    ];

    protected function casts(): array
    {
        return [
            'validated_at' => 'datetime',
        ];
    }

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($ticket) {
            $ticket->uuid = $ticket->uuid ?? Str::uuid()->toString();
        });
    }

    public function event() { return $this->belongsTo(Event::class); }
    public function guest() { return $this->belongsTo(Guest::class); }
    public function validatedBy() { return $this->belongsTo(User::class, 'validated_by'); }
    public function scanLogs() { return $this->hasMany(ScanLog::class); }

    public function generateQrCode(): string
    {
        $url = route('ticket.show', $this->uuid);
        $path = 'qrcodes/' . $this->uuid . '.svg';
        $fullPath = storage_path('app/public/' . $path);

        if (!file_exists(dirname($fullPath))) {
            mkdir(dirname($fullPath), 0755, true);
        }

        QrCode::format('svg')->size(300)->generate($url, $fullPath);

        $this->update(['qr_code_path' => $path]);
        return $path;
    }

    public function getQrCodeUrlAttribute(): ?string
    {
        return $this->qr_code_path ? asset('storage/' . $this->qr_code_path) : null;
    }
}
