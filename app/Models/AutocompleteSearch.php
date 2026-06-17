<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class AutocompleteSearch extends Model
{
    protected $fillable = [
        'keyword',
        'status'
    ];
}