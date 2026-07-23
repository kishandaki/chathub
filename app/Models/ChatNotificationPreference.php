<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ChatNotificationPreference extends Model
{
    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'in_app_enabled' => 'boolean',
            'browser_enabled' => 'boolean',
            'email_enabled' => 'boolean',
            'push_enabled' => 'boolean',
            'notify_direct_messages' => 'boolean',
            'notify_group_messages' => 'boolean',
            'notify_mentions' => 'boolean',
            'notify_file_shares' => 'boolean',
            'notify_group_adds' => 'boolean',
            'quiet_hours_start' => 'datetime',
            'quiet_hours_end' => 'datetime',
            'is_global_mute' => 'boolean',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}