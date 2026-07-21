<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('chat_recovery_access_logs', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('recovery_request_id')->constrained('chat_recovery_requests')->cascadeOnDelete();
            $table->unsignedBigInteger('accessed_by')->index();
            $table->foreignId('conversation_id')->nullable()->constrained('chat_conversations')->nullOnDelete();
            $table->foreignId('message_id')->nullable()->constrained('chat_messages')->nullOnDelete();
            $table->string('action', 50)->index(); // viewed, exported, downloaded, printed.
            $table->ipAddress('ip_address')->nullable();
            $table->text('user_agent')->nullable();
            $table->json('metadata')->nullable();
            $table->timestamp('created_at')->useCurrent();

            $table->index(['recovery_request_id', 'created_at'], 'chat_recovery_access_request_created_idx');
            $table->index(['accessed_by', 'created_at'], 'chat_recovery_access_user_created_idx');
            $table->index(['conversation_id', 'message_id'], 'chat_recovery_access_conv_msg_idx');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('chat_recovery_access_logs');
    }
};
