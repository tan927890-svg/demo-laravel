<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CarGallery extends Model
{
    protected $fillable = [
        'car_id', 'file_path', 'type',
        'thumbnail', 'caption', 'sort_order',
    ];

    public function car(): BelongsTo
    {
        return $this->belongsTo(Car::class);
    }

    public function isVideo(): bool
    {
        return $this->type === 'video';
    }

    public function isImage(): bool
    {
        return $this->type === 'image';
    }

    public function url(): string
    {
        return asset($this->file_path);
    }

    public function thumbnailUrl(): string
    {
        return $this->thumbnail
            ? asset($this->thumbnail)
            : $this->url();
    }
}