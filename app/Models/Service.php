<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Service extends Model
{
    protected $fillable = [
        'icon',
        'featured',
        'status',
        'order',
        'is_demo',
    ];

    protected function casts(): array
    {
        return [
            'featured' => 'boolean',
            'is_demo' => 'boolean',
            'order' => 'integer',
        ];
    }

    public function translations(): HasMany
    {
        return $this->hasMany(ServiceTranslation::class);
    }

    public function translation(string $locale = 'fa')
    {
        return $this->translations->firstWhere('locale', $locale)
            ?? $this->translations->first();
    }

    public function projects(): BelongsToMany
    {
        return $this->belongsToMany(Project::class, 'service_project');
    }
}
