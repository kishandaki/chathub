<?php

namespace App\Services\Chat;

use App\Models\ChatMessage;
use App\Models\Conversation;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class MessageService
{
    public function send(Conversation $conversation, User $sender, array $data): ChatMessage
    {
        return DB::transaction(function () use ($conversation, $sender, $data) {
            $message = $conversation->messages()->create([
                'sender_id' => $sender->id,
                'body' => $data['body'] ?? null,
                'encrypted_payload' => $data['encrypted_payload'] ?? null,
                'encryption_version' => $data['encryption_version'] ?? null,
                'message_type' => $data['message_type'] ?? 'text',
                'reply_to_id' => $data['reply_to_id'] ?? null,
                'created_by' => $sender->id,
            ]);

            $message->statuses()->create([
                'user_id' => $sender->id,
                'status' => 'sent',
                'status_at' => now(),
            ]);

            return $message;
        });
    }
}