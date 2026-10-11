<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Estimate extends Model
{
    protected $fillable = [
        'public_id',
        'scope_type',
        'estimated_amount',
        'currency',
        'breakdown',
        'ip_address',
    ];

    protected function casts(): array
    {
        return [
            'estimated_amount' => 'integer',
            'breakdown' => 'array',
        ];
    }

    protected static function booted()
    {
        static::creating(function ($estimate) {
            if (empty($estimate->public_id)) {
                $estimate->public_id = (string) Str::ulid();
            }
        });
    }
}
