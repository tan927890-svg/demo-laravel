<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Notification extends Model
{
    protected $fillable = [
        'user_id',
        'created_by',
        'title',
        'body',
        'type',
        'target_role',
        'data',
    ];

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function readers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'notification_reads', 'notification_id', 'user_id')
                    ->withPivot('read_at');
    }

    public function isReadBy(User $user): bool
    {
        return $this->readers()->where('user_id', $user->id)->exists();
    }

    public static function forUser(User $user)
    {
        return static::where(function ($q) use ($user) {
            $q->whereNull('target_role')
              ->orWhere('target_role', 'all')
              ->orWhere('target_role', $user->role);
        })->latest();
    }

    public function typeColor(): string
    {
        return match($this->type) {
            'urgent'  => '#dc2626',
            'warning' => '#d97706',
            'success' => '#16a34a',
            default   => '#2563eb',
        };
    }

    public function typeIcon(): string
    {
        return match($this->type) {
            'urgent'  => '🚨',
            'warning' => '⚠️',
            'success' => '✅',
            default   => 'ℹ️',
        };
    }
}