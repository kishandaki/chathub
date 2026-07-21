<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('chat_notification_deliveries', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->unsignedBigInteger('organization_id')->nullable()->index();
            $table->unsignedBigInteger('user_id')->index();
            $table->foreignId('conversation_id')->nullable()->constrained('chat_conversations')->nullOnDelete();
            $table->foreignId('message_id')->nullable()->constrained('chat_messages')->nullOnDelete();
            $table->string('event_type', 80)->index();
            $table->string('channel', 30)->index();
            $table->string('status', 30)->default('pending')->index(); // pending, sent, failed, read, skipped.
            $table->string('provider_message_id')->nullable()->index();
            $table->text('safe_title')->nullable(); // Do not store encrypted message body here.
            $table->text('safe_body')->nullable(); // Use generic text when E2E is enabled.
            $table->text('error_message')->nullable();
            $table->unsignedSmallInteger('retry_count')->default(0);
            $table->timestamp('scheduled_at')->nullable()->index();
            $table->timestamp('sent_at')->nullable()->index();
            $table->timestamp('read_at')->nullable()->index();
            $table->timestamps();

            $table->index(['user_id', 'status', 'created_at'], 'chat_notif_delivery_user_status_created_idx');
            $table->index(['organization_id', 'channel', 'status'], 'chat_notif_delivery_org_channel_status_idx');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('chat_notification_deliveries');
    }
};
