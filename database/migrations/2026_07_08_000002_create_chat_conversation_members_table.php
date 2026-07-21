<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('chat_conversation_members', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('conversation_id')->constrained('chat_conversations')->cascadeOnDelete();
            $table->unsignedBigInteger('user_id')->index(); // Map to existing users table.
            $table->string('member_role', 40)->default('member')->index(); // owner, admin, member, compliance, recovery_shadow.
            $table->boolean('can_send')->default(true);
            $table->boolean('can_upload')->default(true);
            $table->boolean('is_muted')->default(false)->index();
            $table->unsignedBigInteger('last_read_message_id')->nullable()->index();
            $table->timestamp('last_read_at')->nullable();
            $table->unsignedInteger('unread_count')->default(0);
            $table->unsignedInteger('encryption_join_version')->nullable();
            $table->timestamp('joined_at')->nullable()->index();
            $table->timestamp('left_at')->nullable()->index();
            $table->unsignedBigInteger('removed_by')->nullable()->index();
            $table->unsignedBigInteger('created_by')->nullable()->index();
            $table->unsignedBigInteger('updated_by')->nullable()->index();
            $table->timestamps();

            $table->unique(['conversation_id', 'user_id'], 'chat_members_conversation_user_unique');
            $table->index(['user_id', 'left_at'], 'chat_members_user_left_idx');
            $table->index(['conversation_id', 'member_role'], 'chat_members_conv_role_idx');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('chat_conversation_members');
    }
};
