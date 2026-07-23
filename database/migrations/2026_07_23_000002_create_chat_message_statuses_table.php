<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('chat_message_statuses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('message_id')->constrained('chat_messages')->cascadeOnDelete();
            $table->unsignedBigInteger('user_id')->index();
            $table->string('status', 30)->default('sent')->index(); // sent, delivered, read
            $table->timestamp('status_at')->nullable();
            $table->timestamps();

            $table->unique(['message_id', 'user_id'], 'chat_msg_status_msg_user_unique');
            $table->index(['user_id', 'status'], 'chat_msg_status_user_status_idx');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('chat_message_statuses');
    }
};