<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Master extends Model
{
    protected $fillable = [
        'tenant_id', 'page', 'name', 'short_title', 'long_title',
        'short_description', 'long_description', 'image', 'image2',
        'content', 'meta_title', 'meta_description', 'meta_image', 'meta_keywords',
    ];

    protected $casts = [
        'content' => 'array',
    ];
}