<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Tag extends Model
{
    protected $fillable = [];

    public function translations(): HasMany
    {
        return $this->hasMany(TagTranslation::class);
    }

    public function translation(string $locale = 'fa')
    {
        return $this->translations->firstWhere('locale', $locale)
            ?? $this->translations->first();
    }

    public function posts(): BelongsToMany
    {
        return $this->belongsToMany(Post::class, 'post_tag');
    }
}
