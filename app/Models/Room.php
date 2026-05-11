<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Room extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'capacity' => 'integer',
        ];
    }

    public function sessions(): HasMany
    {
        return $this->hasMany(ProgramSession::class);
    }

    public function symposiums(): HasMany
    {
        return $this->hasMany(Symposium::class);
    }
}
