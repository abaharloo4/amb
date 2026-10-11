<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Inquiry extends Model
{
    protected $fillable = [
        'public_id',
        'name',
        'email',
        'phone',
        'company',
        'service_type',
        'budget_tier',
        'timeline',
        'subject',
        'message',
        'data',
        'metadata',
        'status',
        'ip_address',
        'user_agent',
    ];

    protected static function booted()
    {
        static::creating(function ($inquiry) {
            if (empty($inquiry->public_id)) {
                $inquiry->public_id = (string) \Illuminate\Support\Str::ulid();
            }
        });
    }

    protected function casts(): array
    {
        return [
            'data' => 'array',
            'metadata' => 'array',
        ];
    }

    public function events(): HasMany
    {
        return $this->hasMany(InquiryEvent::class)->latest();
    }
}
