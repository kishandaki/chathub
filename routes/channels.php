<?php

use Illuminate\Support\Facades\Broadcast;
use App\Models\Conversation;
use App\Models\ConversationMember;

Broadcast::channel('private-chat.conversation.{conversationId}', function ($user, $conversationId) {
    return ConversationMember::where('conversation_id', $conversationId)
        ->where('user_id', $user->id)
        ->exists();
});

Broadcast::channel('private-chat.user.{userId}', function ($user, $userId) {
    return (int) $user->id === (int) $userId;
});

Broadcast::channel('private-chat.admin.{organizationId}', function ($user, $organizationId) {
    return $user->hasRole('admin') && $user->organization_id === (int) $organizationId;
});

Broadcast::channel('presence-chat.organization.{organizationId}', function ($user, $organizationId) {
    return $user->organization_id === (int) $organizationId;
});

Broadcast::channel('presence-chat.conversation.{conversationId}', function ($user, $conversationId) {
    return ConversationMember::where('conversation_id', $conversationId)
        ->where('user_id', $user->id)
        ->exists();
});