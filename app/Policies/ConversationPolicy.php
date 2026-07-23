<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Conversation;
use Illuminate\Auth\Access\AuthorizationException;

class ConversationPolicy
{
    public function view(User $user, Conversation $conversation): bool
    {
        return $conversation->members()->where('user_id', $user->id)->exists();
    }

    public function update(User $user, Conversation $conversation): bool
    {
        $member = $conversation->members()->where('user_id', $user->id)->first();
        if (! $member) {
            return false;
        }

        return in_array($member->member_role, ['owner', 'admin'], true);
    }

    public function addMembers(User $user, Conversation $conversation): bool
    {
        $member = $conversation->members()->where('user_id', $user->id)->first();
        if (! $member) {
            return false;
        }

        return in_array($member->member_role, ['owner', 'admin'], true);
    }

    public function removeMembers(User $user, Conversation $conversation): bool
    {
        $member = $conversation->members()->where('user_id', $user->id)->first();
        if (! $member) {
            return false;
        }

        return in_array($member->member_role, ['owner', 'admin'], true);
    }

    public function sendMessage(User $user, Conversation $conversation): bool
    {
        $member = $conversation->members()->where('user_id', $user->id)->first();

        return (bool) ($member?->can_send ?? false);
    }
}