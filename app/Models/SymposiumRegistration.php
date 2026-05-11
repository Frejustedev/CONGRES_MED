<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class SymposiumRegistration extends Model
{
    protected $guarded = ['id'];

    protected function casts(): array
    {
        return [
            'amount_paid' => 'decimal:2',
            'attended_at' => 'datetime',
        ];
    }

    public function symposium(): BelongsTo
    {
        return $this->belongsTo(Symposium::class);
    }

    public function registration(): BelongsTo
    {
        return $this->belongsTo(Registration::class);
    }

    public function payments(): MorphMany
    {
        return $this->morphMany(Payment::class, 'payable');
    }
}
