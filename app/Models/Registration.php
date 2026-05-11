<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Models\Concerns\LogsActivity;
use Spatie\Activitylog\Support\LogOptions;

class Registration extends Model
{
    use HasFactory;
    use LogsActivity;
    use SoftDeletes;

    protected $guarded = ['id'];

    protected function casts(): array
    {
        return [
            'amount_due' => 'decimal:2',
            'amount_discount' => 'decimal:2',
            'amount_paid' => 'decimal:2',
            'addons' => 'array',
            'addons_amount' => 'decimal:2',
            'badge_generated' => 'boolean',
            'badge_generated_at' => 'datetime',
            'checked_in_at' => 'datetime',
            'visa_letter_requested' => 'boolean',
            'visa_letter_issued' => 'boolean',
            'submitted_at' => 'datetime',
            'confirmed_at' => 'datetime',
            'cancelled_at' => 'datetime',
            'accompanying_persons' => 'integer',
        ];
    }

    public function participant(): BelongsTo
    {
        return $this->belongsTo(Participant::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(RegistrationCategory::class, 'category_id');
    }

    public function promoCode(): BelongsTo
    {
        return $this->belongsTo(PromoCode::class);
    }

    public function groupRegistration(): BelongsTo
    {
        return $this->belongsTo(GroupRegistration::class);
    }

    public function checkedInBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'checked_in_by_user_id');
    }

    public function payments(): MorphMany
    {
        return $this->morphMany(Payment::class, 'payable');
    }

    public function attendances(): HasMany
    {
        return $this->hasMany(Attendance::class);
    }

    public function cmeCredits(): HasMany
    {
        return $this->hasMany(CmeCredit::class);
    }

    public function attestations(): HasMany
    {
        return $this->hasMany(Attestation::class);
    }

    public function symposiumRegistrations(): HasMany
    {
        return $this->hasMany(SymposiumRegistration::class);
    }

    public function symposiums(): BelongsToMany
    {
        return $this->belongsToMany(Symposium::class, 'symposium_registrations')
            ->withPivot(['status', 'amount_paid', 'attended_at'])
            ->withTimestamps();
    }

    public function exhibitorLeads(): HasMany
    {
        return $this->hasMany(ExhibitorLead::class);
    }

    public function isFullyPaid(): bool
    {
        return $this->amount_paid >= $this->amount_due - $this->amount_discount;
    }

    public function remainingAmount(): float
    {
        return max(0, (float) ($this->amount_due - $this->amount_discount - $this->amount_paid));
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['status', 'amount_paid', 'pricing_tier', 'checked_in_at'])
            ->logOnlyDirty()
            ->dontLogEmptyChanges()
            ->useLogName('registration');
    }
}
