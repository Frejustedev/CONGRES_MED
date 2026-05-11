<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Attestation extends Model
{
    protected $guarded = ['id'];

    protected function casts(): array
    {
        return [
            'included_sessions' => 'array',
            'total_credits' => 'decimal:2',
            'issued_at' => 'datetime',
            'downloaded_at' => 'datetime',
            'revoked_at' => 'datetime',
            'download_count' => 'integer',
        ];
    }

    public function registration(): BelongsTo
    {
        return $this->belongsTo(Registration::class);
    }

    public function speaker(): BelongsTo
    {
        return $this->belongsTo(Speaker::class);
    }

    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewer_user_id');
    }
}
