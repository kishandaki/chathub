<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('chat_deleted_messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('message_id')->constrained('chat_messages')->cascadeOnDelete();
            $table->foreignId('conversation_id')->constrained('chat_conversations')->cascadeOnDelete();
            $table->unsignedBigInteger('user_id')->nullable()->index(); // Null for delete-for-everyone/admin delete.
            $table->string('delete_scope', 30)->default('for_me')->index(); // for_me, everyone, admin.
            $table->text('reason')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable()->index();
            $table->timestamp('deleted_at')->nullable()->index();
            $table->timestamps();

            $table->index(['conversation_id', 'deleted_at'], 'chat_deleted_conv_deleted_idx');
            $table->index(['message_id', 'delete_scope'], 'chat_deleted_message_scope_idx');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('chat_deleted_messages');
    }
};
