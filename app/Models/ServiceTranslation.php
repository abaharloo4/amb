<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ServiceTranslation extends Model
{
    protected $fillable = [
        'service_id',
        'locale',
        'slug',
        'title',
        'summary',
        'description',
        'deliverables',
        'faq',
        'search_text',
    ];

    protected function casts(): array
    {
        return [
            'deliverables' => 'array',
            'faq' => 'array',
        ];
    }

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }
}
