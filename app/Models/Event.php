<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'organisateur_id', 'title', 'description', 'type',
        'date_start', 'date_end', 'venue', 'address', 'city',
        'capacity', 'cover_image', 'status', 'is_paid', 'price',
        'currency', 'program', 'gallery',
    ];

    protected function casts(): array
    {
        return [
            'date_start' => 'datetime',
            'date_end' => 'datetime',
            'is_paid' => 'boolean',
            'program' => 'array',
            'gallery' => 'array',
            'price' => 'decimal:2',
        ];
    }

    public function organisateur() { return $this->belongsTo(User::class, 'organisateur_id'); }
    public function guests() { return $this->hasMany(Guest::class); }
    public function tickets() { return $this->hasMany(Ticket::class); }
    public function staff() { return $this->belongsToMany(User::class, 'event_staff')->withPivot('role')->withTimestamps(); }
    public function scanLogs() { return $this->hasMany(ScanLog::class); }
    public function payments() { return $this->hasMany(Payment::class); }

    public function getPresentsCountAttribute(): int
    {
        return $this->tickets()->where('status', 'valide')->count();
    }

    public function getAvailableSpotsAttribute(): int
    {
        return max(0, $this->capacity - $this->guests()->count());
    }

    public function scopePublished($query) { return $query->where('status', 'publie'); }
    public function scopeForOrganisateur($query, $userId) { return $query->where('organisateur_id', $userId); }
}
