<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('chat_messages', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('conversation_id')->constrained('chat_conversations')->cascadeOnDelete();
            $table->unsignedBigInteger('sender_id')->nullable()->index(); // Nullable for system messages.
            $table->unsignedBigInteger('parent_message_id')->nullable()->index(); // Reply/thread reference.
            $table->string('message_type', 30)->default('text')->index(); // text, file, system, event.
            $table->longText('encrypted_payload')->nullable();
            $table->string('payload_hash', 128)->nullable()->index();
            $table->string('encryption_mode', 50)->default('enterprise_recovery')->index();
            $table->string('encryption_version', 30)->nullable();
            $table->string('nonce', 255)->nullable();
            $table->string('auth_tag', 255)->nullable();
            $table->json('aad')->nullable(); // Additional authenticated data metadata.
            $table->unsignedInteger('payload_size')->nullable();
            $table->boolean('is_edited')->default(false)->index();
            $table->timestamp('edited_at')->nullable();
            $table->boolean('is_system')->default(false)->index();
            $table->timestamp('sent_at')->nullable()->index();
            $table->unsignedBigInteger('deleted_by')->nullable()->index();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['conversation_id', 'id'], 'chat_messages_conv_id_idx');
            $table->index(['conversation_id', 'created_at'], 'chat_messages_conv_created_idx');
            $table->index(['sender_id', 'created_at'], 'chat_messages_sender_created_idx');
            $table->index(['conversation_id', 'message_type'], 'chat_messages_conv_type_idx');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('chat_messages');
    }
};
