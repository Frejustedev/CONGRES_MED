<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class NewsArticle extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;
    use SoftDeletes;

    protected $guarded = ['id'];

    protected function casts(): array
    {
        return [
            'tags' => 'array',
            'is_published' => 'boolean',
            'is_featured' => 'boolean',
            'is_pinned' => 'boolean',
            'allow_comments' => 'boolean',
            'published_at' => 'datetime',
            'view_count' => 'integer',
            'reading_time' => 'integer',
        ];
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_user_id');
    }

    public function calculateReadingTime(): int
    {
        $words = str_word_count(strip_tags($this->body));
        return max(1, (int) ceil($words / 220));
    }

    public function incrementViewCount(): void
    {
        $this->incrementQuietly('view_count');
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true)
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now());
    }
}
