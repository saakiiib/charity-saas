<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tenant extends Model
{
    protected $fillable = [
        'name',
        'domain',
        'tagline',
        'email',
        'phone',
        'logo',
        'primary_color',
        'status'
    ];
}
