<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Post extends Model
{
    protected $fillable = [
        'tenant_id', 'title', 'slug', 'short_description',
        'long_description', 'image', 'status',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($post) {
            $post->slug = Str::slug($post->title);
        });
        static::updating(function ($post) {
            $post->slug = Str::slug($post->title);
        });
    }
}