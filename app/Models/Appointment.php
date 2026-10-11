<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Appointment extends Model
{
    protected $fillable = [
        'public_id',
        'meeting_type_id',
        'client_name',
        'client_email',
        'client_phone',
        'start_time',
        'end_time',
        'status',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'start_time' => 'datetime',
            'end_time' => 'datetime',
        ];
    }

    protected static function booted()
    {
        static::creating(function ($appointment) {
            if (empty($appointment->public_id)) {
                $appointment->public_id = (string) Str::ulid();
            }
        });
    }

    public function meetingType(): BelongsTo
    {
        return $this->belongsTo(MeetingType::class);
    }
}
