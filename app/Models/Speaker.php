<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Speaker extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;
    use SoftDeletes;

    protected $guarded = ['id'];

    protected function casts(): array
    {
        return [
            'is_keynote' => 'boolean',
            'is_featured' => 'boolean',
            'is_published' => 'boolean',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function sessions(): BelongsToMany
    {
        return $this->belongsToMany(ProgramSession::class, 'session_speakers', 'speaker_id', 'session_id')
            ->withPivot(['role', 'talk_title', 'talk_abstract', 'duration_minutes', 'display_order'])
            ->withTimestamps();
    }

    public function attestations(): HasMany
    {
        return $this->hasMany(Attestation::class);
    }

    public function fullName(): string
    {
        return trim(($this->salutation ? $this->salutation.' ' : '').$this->first_name.' '.$this->last_name);
    }
}
