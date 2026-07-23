<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ChatRecoveryAccessLog extends Model
{
    protected $guarded = [];

    protected function casts(): array
    {
        return [];
    }

    public function recoveryRequest(): BelongsTo
    {
        return $this->belongsTo(ChatRecoveryRequest::class, 'recovery_request_id');
    }

    public function accessedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'accessed_by');
    }
}