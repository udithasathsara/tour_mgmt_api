<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enquiry extends Model
{
    use HasFactory;
    //
    protected $fillable = [
        'name',
        'email',
        'travel_start_date',
        'travel_end_date',
        'number_of_people',
        'preferred_destinations',
        'budget',
        'status'
    ];

    protected $casts = [
        'preferred_destinations' => 'array',
        'travel_start_date' => 'date:Y-m-d',
        'travel_end_date' => 'date:Y-m-d'
    ];
}
