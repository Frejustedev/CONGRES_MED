<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AbstractFile extends Model
{
    protected $guarded = ['id'];

    protected function casts(): array
    {
        return [
            'size_bytes' => 'integer',
            'display_order' => 'integer',
        ];
    }

    public function abstrakt(): BelongsTo
    {
        return $this->belongsTo(Abstrakt::class, 'abstract_id');
    }
}
