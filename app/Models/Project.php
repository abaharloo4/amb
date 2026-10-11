<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Project extends Model
{
    protected $fillable = [
        'public_id',
        'featured',
        'status',
        'order',
        'is_demo',
        'github_url',
        'live_url',
        'published_at',
        'created_by',
    ];

    protected static function booted()
    {
        static::creating(function ($project) {
            if (empty($project->public_id)) {
                $project->public_id = (string) \Illuminate\Support\Str::ulid();
            }
        });
    }

    /**
     * Get primary slug from active or fallback translation.
     */
    public function getSlugAttribute(): string
    {
        return $this->translation()?->slug ?? 'project-' . $this->id;
    }

    protected function casts(): array
    {
        return [
            'featured' => 'boolean',
            'is_demo' => 'boolean',
            'order' => 'integer',
            'published_at' => 'datetime',
        ];
    }

    public function translations(): HasMany
    {
        return $this->hasMany(ProjectTranslation::class);
    }

    public function translation(string $locale = 'fa')
    {
        return $this->translations->firstWhere('locale', $locale)
            ?? $this->translations->first();
    }

    public function technologies(): BelongsToMany
    {
        return $this->belongsToMany(Technology::class, 'project_technology');
    }

    public function media(): HasMany
    {
        return $this->hasMany(ProjectMedia::class)->orderBy('sort_order');
    }
}
