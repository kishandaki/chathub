<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ChatRecoveryApproval extends Model
{
    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'decided_at' => 'datetime',
        ];
    }

    public function recoveryRequest(): BelongsTo
    {
        return $this->belongsTo(ChatRecoveryRequest::class, 'recovery_request_id');
    }

    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
}