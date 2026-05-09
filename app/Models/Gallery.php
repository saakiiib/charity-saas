<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    protected $fillable = [
        'tenant_id', 'title', 'image', 'video', 'status', 'serial',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];
}