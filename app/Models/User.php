<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'role', 'phone', 'avatar',
        'organisateur_id', 'is_active',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
        ];
    }

    public function isAdmin(): bool { return $this->role === 'admin'; }
    public function isOrganisateur(): bool { return $this->role === 'organisateur'; }
    public function isAgent(): bool { return $this->role === 'agent'; }
    public function isInvite(): bool { return $this->role === 'invite'; }

    public function organisateur() { return $this->belongsTo(User::class, 'organisateur_id'); }
    public function agents() { return $this->hasMany(User::class, 'organisateur_id'); }
    public function events() { return $this->hasMany(Event::class, 'organisateur_id'); }
    public function assignedEvents() { return $this->belongsToMany(Event::class, 'event_staff')->withPivot('role')->withTimestamps(); }
    public function scanLogs() { return $this->hasMany(ScanLog::class, 'scanned_by'); }

    public function getAvatarUrlAttribute(): string
    {
        return $this->avatar
            ? asset('storage/' . $this->avatar)
            : 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&background=6366f1&color=fff';
    }
}
