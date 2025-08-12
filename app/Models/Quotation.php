<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Quotation extends Model
{
    //
    protected $keyType = 'string';
    public $incrementing = false;
    protected $fillable = [
        'id',
        'itinerary_id',
        'title',
        'price_per_person',
        'currency',
        'notes',
        'is_final'
    ];

    public function itinerary(): BelongsTo
    {
        return $this->belongsTo(Itinerary::class, 'itinerary_id');
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }
}
