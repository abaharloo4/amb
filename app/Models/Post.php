<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Post extends Model
{
    protected $fillable = [
        'category_id',
        'author_id',
        'slug',
        'featured_image',
        'status',
        'reading_time_minutes',
        'views_count',
        'published_at',
    ];

    protected function casts(): array
    {
        return [
            'reading_time_minutes' => 'integer',
            'views_count' => 'integer',
            'published_at' => 'datetime',
        ];
    }

    public function translations(): HasMany
    {
        return $this->hasMany(PostTranslation::class);
    }

    public function translation(string $locale = 'fa')
    {
        return $this->translations->firstWhere('locale', $locale)
            ?? $this->translations->first();
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'post_tag');
    }
}
