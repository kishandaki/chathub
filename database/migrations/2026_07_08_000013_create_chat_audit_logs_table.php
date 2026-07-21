<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('chat_audit_logs', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->unsignedBigInteger('organization_id')->nullable()->index();
            $table->unsignedBigInteger('actor_id')->nullable()->index();
            $table->string('action', 100)->index();
            $table->string('entity_type', 100)->nullable()->index();
            $table->unsignedBigInteger('entity_id')->nullable()->index();
            $table->foreignId('conversation_id')->nullable()->constrained('chat_conversations')->nullOnDelete();
            $table->foreignId('message_id')->nullable()->constrained('chat_messages')->nullOnDelete();
            $table->unsignedBigInteger('target_user_id')->nullable()->index();
            $table->ipAddress('ip_address')->nullable();
            $table->text('user_agent')->nullable();
            $table->json('metadata')->nullable();
            $table->timestamp('created_at')->useCurrent();

            $table->index(['organization_id', 'created_at'], 'chat_audit_org_created_idx');
            $table->index(['actor_id', 'created_at'], 'chat_audit_actor_created_idx');
            $table->index(['action', 'created_at'], 'chat_audit_action_created_idx');
            $table->index(['entity_type', 'entity_id'], 'chat_audit_entity_idx');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('chat_audit_logs');
    }
};
