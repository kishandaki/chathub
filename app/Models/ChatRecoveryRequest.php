<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ChatRecoveryRequest extends Model
{
    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'date_from' => 'datetime',
            'date_to' => 'datetime',
            'approved_at' => 'datetime',
            'expires_at' => 'datetime',
        ];
    }

    public function conversation(): BelongsTo
    {
        return $this->belongsTo(Conversation::class, 'conversation_id');
    }

    public function requestedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'requested_by');
    }

    public function approvedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function approvals()
    {
        return $this->hasMany(ChatRecoveryApproval::class, 'recovery_request_id');
    }
}