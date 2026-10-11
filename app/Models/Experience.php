<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Experience extends Model
{
    protected $fillable = [
        'start_date',
        'end_date',
        'is_current',
        'order',
    ];

    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'end_date' => 'date',
            'is_current' => 'boolean',
            'order' => 'integer',
        ];
    }

    public function translations(): HasMany
    {
        return $this->hasMany(ExperienceTranslation::class);
    }

    public function translation(string $locale = 'fa')
    {
        return $this->translations->firstWhere('locale', $locale)
            ?? $this->translations->first();
    }
}
