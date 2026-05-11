<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class RegistrationCategory extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = ['id'];

    protected function casts(): array
    {
        return [
            'price_early_bird' => 'decimal:2',
            'price_standard' => 'decimal:2',
            'price_late' => 'decimal:2',
            'early_bird_until' => 'datetime',
            'standard_until' => 'datetime',
            'included_addons' => 'array',
            'requires_proof' => 'boolean',
            'is_public' => 'boolean',
            'is_active' => 'boolean',
        ];
    }

    public function registrations(): HasMany
    {
        return $this->hasMany(Registration::class, 'category_id');
    }

    public function currentPrice(): float
    {
        $now = now();
        if ($this->early_bird_until && $now->lte($this->early_bird_until)) {
            return (float) $this->price_early_bird;
        }
        if ($this->standard_until && $now->lte($this->standard_until)) {
            return (float) $this->price_standard;
        }
        return (float) $this->price_late;
    }

    public function currentTier(): string
    {
        $now = now();
        if ($this->early_bird_until && $now->lte($this->early_bird_until)) {
            return 'early_bird';
        }
        if ($this->standard_until && $now->lte($this->standard_until)) {
            return 'standard';
        }
        return 'late';
    }
}
