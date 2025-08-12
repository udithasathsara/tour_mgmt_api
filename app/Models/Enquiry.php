<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
        'status',
        'assigned_agent_id'
    ];

    protected $casts = [
        'preferred_destinations' => 'array',
        'travel_start_date' => 'date:Y-m-d',
        'travel_end_date' => 'date:Y-m-d'
    ];

    public function assignedAgent(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_agent_id');
    }

    public function scopeAssignedTo($query, $agentId)
    {
        return $query->where('assigned_agent_id', $agentId);
    }

    public function scopeStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function scopeDateRange($query, $from, $to)
    {
        return $query->whereBetween('created_at', [$from, $to]);
    }

    public function scopeSearch($query, $term)
    {
        return $query->where(function ($q) use ($term) {
            $q->where('name', 'like', "%$term%")
                ->orWhere('email', 'like', "%$term%");
        });
    }

    public function itineraries()
    {
        return $this->hasMany(Itinerary::class);
    }
}
