<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Event extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = ['id'];

    protected function casts(): array
    {
        return [
            'starts_at' => 'datetime',
            'ends_at' => 'datetime',
            'registration_opens_at' => 'datetime',
            'registration_closes_at' => 'datetime',
            'abstracts_open_at' => 'datetime',
            'abstracts_close_at' => 'datetime',
            'is_active' => 'boolean',
            'max_capacity' => 'integer',
            'venue_latitude' => 'decimal:7',
            'venue_longitude' => 'decimal:7',
        ];
    }

    public function isRegistrationOpen(): bool
    {
        $now = now();
        return $this->is_active
            && in_array($this->status, ['published', 'registration_open', 'live'], true)
            && (! $this->registration_opens_at || $now->gte($this->registration_opens_at))
            && (! $this->registration_closes_at || $now->lte($this->registration_closes_at));
    }
}
