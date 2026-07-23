<?php

namespace App\Services\Chat;

use App\Models\Conversation;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class ConversationService
{
    public function startDirect(User $user, User $target): Conversation
    {
        return DB::transaction(function () use ($user, $target) {
            $conversation = Conversation::create([
                'type' => 'direct',
                'organization_id' => $user->organization_id,
                'created_by' => $user->id,
            ]);

            $conversation->members()->createMany([
                ['user_id' => $user->id, 'member_role' => 'owner', 'can_send' => true, 'can_upload' => true],
                ['user_id' => $target->id, 'member_role' => 'member', 'can_send' => true, 'can_upload' => true],
            ]);

            return $conversation;
        });
    }

    public function createGroup(array $data, User $creator): Conversation
    {
        return DB::transaction(function () use ($data, $creator) {
            $conversation = Conversation::create([
                'type' => 'group',
                'name' => $data['name'] ?? null,
                'description' => $data['description'] ?? null,
                'organization_id' => $creator->organization_id,
                'created_by' => $creator->id,
            ]);

            $conversation->members()->create([
                'user_id' => $creator->id,
                'member_role' => 'owner',
                'can_send' => true,
                'can_upload' => true,
            ]);

            if (!empty($data['member_ids'])) {
                $conversation->members()->createMany(
                    collect($data['member_ids'])->map(fn ($userId) => [
                        'user_id' => $userId,
                        'member_role' => 'member',
                        'can_send' => true,
                        'can_upload' => true,
                    ])->toArray()
                );
            }

            return $conversation;
        });
    }
}