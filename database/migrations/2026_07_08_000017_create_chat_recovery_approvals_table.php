<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('chat_recovery_approvals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('recovery_request_id')->constrained('chat_recovery_requests')->cascadeOnDelete();
            $table->unsignedBigInteger('approver_id')->index();
            $table->string('decision', 30)->index(); // approved, rejected, revoked.
            $table->text('comments')->nullable();
            $table->timestamp('decided_at')->nullable()->index();
            $table->ipAddress('ip_address')->nullable();
            $table->text('user_agent')->nullable();
            $table->timestamps();

            $table->index(['recovery_request_id', 'decision'], 'chat_recovery_approval_request_decision_idx');
            $table->index(['approver_id', 'decided_at'], 'chat_recovery_approval_approver_decided_idx');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('chat_recovery_approvals');
    }
};
