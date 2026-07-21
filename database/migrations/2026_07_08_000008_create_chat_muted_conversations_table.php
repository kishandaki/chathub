<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('chat_muted_conversations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('conversation_id')->constrained('chat_conversations')->cascadeOnDelete();
            $table->unsignedBigInteger('user_id')->index();
            $table->timestamp('muted_until')->nullable()->index(); // Null means muted until turned back on.
            $table->unsignedBigInteger('created_by')->nullable()->index();
            $table->timestamps();

            $table->unique(['conversation_id', 'user_id'], 'chat_muted_conversation_user_unique');
            $table->index(['user_id', 'muted_until'], 'chat_muted_user_until_idx');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('chat_muted_conversations');
    }
};
