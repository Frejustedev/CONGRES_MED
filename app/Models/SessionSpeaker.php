<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SessionSpeaker extends Model
{
    protected $guarded = ['id'];

    protected function casts(): array
    {
        return [
            'duration_minutes' => 'integer',
            'display_order' => 'integer',
        ];
    }

    public function session(): BelongsTo
    {
        return $this->belongsTo(ProgramSession::class, 'session_id');
    }

    public function speaker(): BelongsTo
    {
        return $this->belongsTo(Speaker::class);
    }
}
