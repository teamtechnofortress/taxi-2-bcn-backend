<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Webhook extends Model
{
    protected $fillable = [

        'event_id',
        'event_type',
        'stripe_object_id',
        'payload',
        'status',
        'error_message',
    ];

    protected $casts = [

        'payload' => 'array',
    ];
}