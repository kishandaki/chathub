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
            $table->unsignedBigInteger('sender_id')->index();
            $table->text('body')->nullable(); // plaintext only if encryption_mode = none
            $table->text('encrypted_payload')->nullable(); // encrypted blob if encryption active
            $table->string('encryption_version', 50)->nullable()->index();
            $table->string('message_type', 30)->default('text')->index(); // text, image, file, system
            $table->unsignedBigInteger('reply_to_id')->nullable()->index();
            $table->unsignedBigInteger('edited_by')->nullable()->index();
            $table->timestamp('edited_at')->nullable();
            $table->timestamp('deleted_at')->nullable()->index();
            $table->unsignedBigInteger('deleted_by')->nullable()->index();
            $table->unsignedBigInteger('created_by')->nullable()->index();
            $table->unsignedBigInteger('updated_by')->nullable()->index();
            $table->timestamps();

            $table->index(['conversation_id', 'created_at', 'id'], 'chat_msg_conv_created_idx');
            $table->index(['sender_id', 'created_at'], 'chat_msg_sender_created_idx');
            $table->index(['conversation_id', 'deleted_at'], 'chat_msg_conv_deleted_idx');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('chat_messages');
    }
};