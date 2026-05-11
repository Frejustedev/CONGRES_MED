<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AbstractAuthor extends Model
{
    protected $guarded = ['id'];

    protected function casts(): array
    {
        return [
            'is_corresponding' => 'boolean',
            'is_presenter' => 'boolean',
            'consent_given' => 'boolean',
            'display_order' => 'integer',
        ];
    }

    public function abstrakt(): BelongsTo
    {
        return $this->belongsTo(Abstrakt::class, 'abstract_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function fullName(): string
    {
        return trim(($this->salutation ? $this->salutation.' ' : '').$this->first_name.' '.$this->last_name);
    }
}
