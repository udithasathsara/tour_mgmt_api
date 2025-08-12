<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Itinerary extends Model
{
    //
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'enquiry_id',
        'agent_id',
        'title',
        'notes',
        'days'
    ];

    protected $casts = [
        'days' => 'array'
    ];

    public function enquiry(): BelongsTo
    {
        return $this->belongsTo(Enquiry::class, 'enquiry_id');
    }

    public function agent(): BelongsTo
    {
        return $this->belongsTo(User::class, 'agent_id');
    }
}
