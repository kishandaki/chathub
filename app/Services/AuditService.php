<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class AuditService
{
    public static function log(User $actor, string $action, ?string $entityType = null, ?int $entityId = null, ?int $organizationId = null, ?int $targetUserId = null, ?Request $request = null, array $metadata = []): void
    {
        DB::table('chat_audit_logs')->insert([
            'uuid' => \Illuminate\Support\Str::uuid(),
            'organization_id' => $organizationId ?? $actor->organization_id,
            'actor_id' => $actor->id,
            'action' => $action,
            'entity_type' => $entityType,
            'entity_id' => $entityId,
            'conversation_id' => $metadata['conversation_id'] ?? null,
            'message_id' => $metadata['message_id'] ?? null,
            'target_user_id' => $targetUserId,
            'ip_address' => $request?->ip(),
            'user_agent' => $request?->userAgent(),
            'metadata' => $metadata ?: null,
            'created_at' => now(),
        ]);
    }
}