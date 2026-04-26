<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'is_admin', 'role', 'password_reset_at', 'username', 'avatar',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at'  => 'datetime',
            'is_admin'           => 'boolean',
            'password_reset_at'  => 'datetime',
        ];
    }

    // ── Role helpers ──
    public function isAdmin(): bool   { return $this->role === 'admin'; }
    public function isManager(): bool { return $this->role === 'manager'; }
    public function isStaff(): bool   { return $this->role === 'staff'; }

    public function canManageStaff(): bool
    {
        return in_array($this->role, ['admin', 'manager']);
    }

    // ── Relationships ──
    public function orders()
    {
        return $this->hasMany(Order::class, 'assigned_to');
    }

    public function kpis()
    {
        return $this->hasMany(\App\Models\Kpi::class);
    }

    public function logs()
    {
        return $this->hasMany(\App\Models\UserLog::class)->latest();
    }
}