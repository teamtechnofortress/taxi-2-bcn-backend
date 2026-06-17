<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
    'name',
    'email',
    'phone',
    'passengers',

    'pickup_address',
    'pickup_lat',
    'pickup_lng',
    'pickup_city',
    'pickup_place_id',

    'dropoff_address',
    'dropoff_lat',
    'dropoff_lng',
    'dropoff_city',
    'dropoff_place_id',

    'travel_date',
    'travel_time',
];
    public function payment()
{
    return $this->hasOne(Payment::class);
}
}
