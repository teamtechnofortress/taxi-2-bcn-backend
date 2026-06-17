<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class AutocompleteResult extends Model
{
    protected $fillable = [

        'search_id',
        'place_id',
        'display_name',
        'city',
        'lat',
        'lon',
    ];
}
