<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Conversation extends Model
{
    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'recovery_enabled' => 'boolean',
            'is_system_generated' => 'boolean',
        ];
    }

    public function members(): HasMany
    {
        return $this->hasMany(ConversationMember::class, 'conversation_id');
    }

    public function messages(): HasMany
    {
        return $this->hasMany(ChatMessage::class, 'conversation_id');
    }

    public function lastMessage(): BelongsTo
    {
        return $this->belongsTo(ChatMessage::class, 'last_message_id');
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'chat_conversation_members', 'conversation_id', 'user_id')
            ->withPivot([
                'member_role','can_send','can_upload','is_muted','last_read_message_id',
                'last_read_at','unread_count','encryption_join_version','joined_at','left_at','removed_by',
            ])
            ->withTimestamps();
    }
}