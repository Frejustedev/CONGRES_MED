<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CmeCredit extends Model
{
    protected $guarded = ['id'];

    protected function casts(): array
    {
        return [
            'credits' => 'decimal:2',
            'quiz_required' => 'boolean',
            'quiz_passed' => 'boolean',
            'quiz_score' => 'integer',
            'earned_at' => 'datetime',
            'quiz_attempted_at' => 'datetime',
            'quiz_answers' => 'array',
            'validated' => 'boolean',
        ];
    }

    public function registration(): BelongsTo
    {
        return $this->belongsTo(Registration::class);
    }

    public function session(): BelongsTo
    {
        return $this->belongsTo(ProgramSession::class, 'session_id');
    }

    public function validatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'validated_by_user_id');
    }
}
