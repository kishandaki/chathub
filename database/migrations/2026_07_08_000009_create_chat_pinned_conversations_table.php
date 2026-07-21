<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('chat_pinned_conversations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('conversation_id')->constrained('chat_conversations')->cascadeOnDelete();
            $table->unsignedBigInteger('user_id')->index();
            $table->unsignedInteger('sort_order')->default(0);
            $table->unsignedBigInteger('created_by')->nullable()->index();
            $table->timestamps();

            $table->unique(['conversation_id', 'user_id'], 'chat_pinned_conversation_user_unique');
            $table->index(['user_id', 'sort_order'], 'chat_pinned_user_sort_idx');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('chat_pinned_conversations');
    }
};
