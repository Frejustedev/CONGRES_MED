<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\Models\Concerns\LogsActivity;
use Spatie\Activitylog\Support\LogOptions;

class AbstractReview extends Model
{
    use LogsActivity;

    protected $guarded = ['id'];

    protected function casts(): array
    {
        return [
            'assigned_at' => 'datetime',
            'due_at' => 'datetime',
            'submitted_at' => 'datetime',
            'declined_at' => 'datetime',
            'weighted_score' => 'decimal:2',
            'conflict_declared' => 'boolean',
            'score_originality' => 'integer',
            'score_methodology' => 'integer',
            'score_relevance' => 'integer',
            'score_clarity' => 'integer',
            'score_overall' => 'integer',
        ];
    }

    public function abstrakt(): BelongsTo
    {
        return $this->belongsTo(Abstrakt::class, 'abstract_id');
    }

    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewer_user_id');
    }

    public function assignedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_by_user_id');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['status', 'recommendation', 'submitted_at'])
            ->logOnlyDirty()
            ->useLogName('abstract_review');
    }
}
