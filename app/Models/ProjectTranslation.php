<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProjectTranslation extends Model
{
    protected $fillable = [
        'project_id',
        'locale',
        'title',
        'summary',
        'body',
        'challenge',
        'solution',
        'role',
        'client',
        'testimonial_quote',
        'meta_title',
        'meta_description',
    ];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }
}
