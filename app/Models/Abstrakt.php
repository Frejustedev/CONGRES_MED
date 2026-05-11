<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Models\Concerns\LogsActivity;
use Spatie\Activitylog\Support\LogOptions;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

/**
 * Représente un résumé scientifique soumis au congrès.
 * Nommé "Abstrakt" car "Abstract" est un mot-clé réservé en PHP.
 * Table : abstracts.
 */
class Abstrakt extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;
    use LogsActivity;
    use SoftDeletes;

    protected $table = 'abstracts';

    protected $guarded = ['id'];

    protected function casts(): array
    {
        return [
            'keywords' => 'array',
            'word_count' => 'integer',
            'is_case_report' => 'boolean',
            'has_conflict_of_interest' => 'boolean',
            'funding_disclosed' => 'boolean',
            'ethical_approval' => 'boolean',
            'submitted_at' => 'datetime',
            'decision_at' => 'datetime',
            'revision_round' => 'integer',
            'is_published' => 'boolean',
            'published_at' => 'datetime',
            'presentation_at' => 'datetime',
            'is_award_candidate' => 'boolean',
            'award_winner' => 'boolean',
            'reviewer_count' => 'integer',
            'average_score' => 'decimal:2',
        ];
    }

    public function submitter(): BelongsTo
    {
        return $this->belongsTo(User::class, 'submitter_user_id');
    }

    public function thematicArea(): BelongsTo
    {
        return $this->belongsTo(ThematicArea::class);
    }

    public function decidedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'decided_by_user_id');
    }

    public function assignedSession(): BelongsTo
    {
        return $this->belongsTo(ProgramSession::class, 'assigned_session_id');
    }

    public function authors(): HasMany
    {
        return $this->hasMany(AbstractAuthor::class, 'abstract_id')->orderBy('display_order');
    }

    public function correspondingAuthor()
    {
        return $this->authors()->where('is_corresponding', true)->first();
    }

    public function presenter()
    {
        return $this->authors()->where('is_presenter', true)->first();
    }

    public function files(): HasMany
    {
        return $this->hasMany(AbstractFile::class, 'abstract_id');
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(AbstractReview::class, 'abstract_id');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['title', 'status', 'submitted_at', 'decision_at', 'is_published'])
            ->logOnlyDirty()
            ->useLogName('abstract');
    }
}
