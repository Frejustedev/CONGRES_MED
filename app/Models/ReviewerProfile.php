<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReviewerProfile extends Model
{
    protected $guarded = ['id'];

    protected function casts(): array
    {
        return [
            'expertise_areas' => 'array',
            'keywords' => 'array',
            'conflicts_of_interest' => 'array',
            'is_available' => 'boolean',
            'available_from' => 'datetime',
            'available_until' => 'datetime',
            'max_assignments' => 'integer',
            'current_load' => 'integer',
            'completed_count' => 'integer',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
