<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MeetingTypeTranslation extends Model
{
    protected $fillable = [
        'meeting_type_id',
        'locale',
        'title',
        'description',
    ];

    public function meetingType(): BelongsTo
    {
        return $this->belongsTo(MeetingType::class);
    }
}
