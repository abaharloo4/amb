<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Inquiry extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'company',
        'service_type',
        'budget_tier',
        'timeline',
        'subject',
        'message',
        'metadata',
        'status',
        'ip_address',
        'user_agent',
    ];

    protected function casts(): array
    {
        return [
            'metadata' => 'array',
        ];
    }

    public function events(): HasMany
    {
        return $this->hasMany(InquiryEvent::class)->latest();
    }
}
