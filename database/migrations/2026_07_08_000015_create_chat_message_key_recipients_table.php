<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('chat_message_key_recipients', function (Blueprint $table) {
            $table->id();
            $table->foreignId('message_id')->constrained('chat_messages')->cascadeOnDelete();
            $table->string('recipient_type', 50)->index(); // user, device, recovery, conversation_member.
            $table->unsignedBigInteger('recipient_id')->nullable()->index();
            $table->foreignId('encryption_key_id')->nullable()->constrained('chat_encryption_keys')->nullOnDelete();
            $table->longText('encrypted_message_key');
            $table->unsignedInteger('key_version')->default(1)->index();
            $table->string('algorithm', 80)->nullable();
            $table->string('nonce', 255)->nullable();
            $table->string('auth_tag', 255)->nullable();
            $table->timestamp('created_at')->useCurrent();

            $table->unique(['message_id', 'recipient_type', 'recipient_id'], 'chat_msg_key_recipient_unique');
            $table->index(['recipient_type', 'recipient_id'], 'chat_msg_key_recipient_idx');
            $table->index(['message_id', 'key_version'], 'chat_msg_key_message_version_idx');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('chat_message_key_recipients');
    }
};
