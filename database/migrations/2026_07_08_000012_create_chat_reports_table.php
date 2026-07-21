<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('chat_reports', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->unsignedBigInteger('organization_id')->nullable()->index();
            $table->foreignId('conversation_id')->nullable()->constrained('chat_conversations')->nullOnDelete();
            $table->foreignId('message_id')->nullable()->constrained('chat_messages')->nullOnDelete();
            $table->unsignedBigInteger('reported_by')->index();
            $table->unsignedBigInteger('reported_user_id')->nullable()->index();
            $table->string('reason_type', 80)->nullable()->index();
            $table->text('reason_text')->nullable();
            $table->string('status', 30)->default('pending')->index(); // pending, reviewing, action_taken, rejected, closed.
            $table->unsignedBigInteger('reviewed_by')->nullable()->index();
            $table->timestamp('reviewed_at')->nullable()->index();
            $table->text('review_notes')->nullable();
            $table->string('action_taken', 100)->nullable();
            $table->timestamps();

            $table->index(['organization_id', 'status'], 'chat_reports_org_status_idx');
            $table->index(['message_id', 'status'], 'chat_reports_message_status_idx');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('chat_reports');
    }
};
