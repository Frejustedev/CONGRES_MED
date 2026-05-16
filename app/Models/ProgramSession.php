<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProgramSession extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'program_sessions';

    protected $guarded = ['id'];

    protected function casts(): array
    {
        return [
            'starts_at' => 'datetime',
            'ends_at' => 'datetime',
            'video_available_until' => 'datetime',
            'is_featured' => 'boolean',
            'is_published' => 'boolean',
            'requires_registration' => 'boolean',
            'requires_separate_payment' => 'boolean',
            'is_streamed' => 'boolean',
            'attachments' => 'array',
            'topics' => 'array',
            'tags' => 'array',
            'cme_credits' => 'integer',
            'quiz_questions' => 'array',
            'quiz_required_for_cme' => 'boolean',
            'quiz_pass_threshold' => 'integer',
        ];
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(ProgramSession::class, 'parent_session_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(ProgramSession::class, 'parent_session_id');
    }

    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }

    public function speakers(): BelongsToMany
    {
        return $this->belongsToMany(Speaker::class, 'session_speakers', 'session_id')
            ->withPivot(['role', 'talk_title', 'talk_abstract', 'duration_minutes', 'display_order'])
            ->withTimestamps()
            ->orderByPivot('display_order');
    }

    public function attendances(): HasMany
    {
        return $this->hasMany(Attendance::class, 'session_id');
    }

    public function cmeCredits(): HasMany
    {
        return $this->hasMany(CmeCredit::class, 'session_id');
    }

    public function abstracts(): HasMany
    {
        return $this->hasMany(Abstrakt::class, 'assigned_session_id');
    }
}
