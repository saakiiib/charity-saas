<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    protected $fillable = [
        'tenant_id', 'name', 'designation', 'company',
        'image', 'message', 'status',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];
}