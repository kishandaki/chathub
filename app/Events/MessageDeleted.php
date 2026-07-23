<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessageDeleted implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public int $messageId;
    public int $conversationId;
    public int $deletedBy;
    public bool $forEveryone;

    public function __construct(int $messageId, int $conversationId, int $deletedBy, bool $forEveryone = false)
    {
        $this->messageId = $messageId;
        $this->conversationId = $conversationId;
        $this->deletedBy = $deletedBy;
        $this->forEveryone = $forEveryone;
    }

    public function broadcastOn(): array
    {
        return [
            new PrivateChannel("private-chat.conversation.{$this->conversationId}"),
        ];
    }

    public function broadcastWith(): array
    {
        return [
            'message_id' => $this->messageId,
            'conversation_id' => $this->conversationId,
            'deleted_by' => $this->deletedBy,
            'for_everyone' => $this->forEveryone,
            'timestamp' => now()->toIso8601String(),
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