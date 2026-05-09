<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Service extends Model
{
    protected $fillable = [
        'tenant_id', 'title', 'slug', 'image',
        'short_description', 'content', 'status', 'serial',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(fn($s) => $s->slug = Str::slug($s->title));
        static::updating(fn($s) => $s->slug = Str::slug($s->title));
    }
}