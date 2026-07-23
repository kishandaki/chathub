<?php

namespace App\Events;

use App\Models\ChatMessage;
use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessageSent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public ChatMessage $message;
    public User $sender;
    public array $payload;

    /**
     * Create a new event instance.
     */
    public function __construct(ChatMessage $message, User $sender, array $payload = [])
    {
        $this->message = $message;
        $this->sender = $sender;
        $this->payload = $payload;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel("private-chat.conversation.{$this->message->conversation_id}"),
            new PrivateChannel("private-chat.user.{$this->message->sender_id}"),
        ];
    }

    /**
     * Get the data to broadcast.
     *
     * @return array<string, mixed>
     */
    public function broadcastWith(): array
    {
        return [
            'message_id' => $this->message->id,
            'conversation_id' => $this->message->conversation_id,
            'sender_id' => $this->message->sender_id,
            'sender' => [
                'id' => $this->sender->id,
                'name' => $this->sender->name,
                'avatar' => $this->sender->avatar_url ?? null,
            ],
            'payload' => $this->payload,
            'status' => $this->message->statuses()->first()?->status ?? 'sent',
            'created_at' => $this->message->created_at?->toIso8601String(),
        ];
    }
}

</parameter>
<task_progress>
- [x] Locate Phase 2 requirements in project docs
- [x] Review existing migration patterns and models
- [x] Create remaining Phase 2 chat migrations
- [x] Create chat models with relationships
- [x] Create chat policies and register them
- [x] Create chat services and repositories
- [x] Create chat controllers and routes
- [x] Fix duplicate migration conflict (chat_messages)
- [x] Run migrations and verify schema
- [x] Ensure all tests pass
- [x] Implement remaining controllers (Message, Presence, Device, NotificationPreference)
- [x] Create ChatHub dashboard layout and controller
- [x] Add common application layout with logout
- [x] Wire ChatHub view to use layout
- [x] Prepare sample data in controller
- [x] Verify route registration
- [x] Review Phase 2 deliverables against acceptance criteria
- [x] Install Laravel Reverb package
- [x] Add Reverb environment variables to .env.example
- [x] Create config/broadcasting.php
- [x] Create routes/channels.php for channel authorization
- [ ] Create ChatHub broadcast events
- [ ] Add broadcasting routes/configuration
- [ ] Add Echo setup to frontend
</task_progress>
</write_to_file>