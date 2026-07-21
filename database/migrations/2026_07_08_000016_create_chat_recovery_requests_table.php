<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('chat_recovery_requests', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->unsignedBigInteger('organization_id')->nullable()->index();
            $table->foreignId('conversation_id')->nullable()->constrained('chat_conversations')->nullOnDelete();
            $table->unsignedBigInteger('requested_by')->index();
            $table->string('reason_type', 80)->index(); // legal, hr, compliance, investigation, audit, other.
            $table->text('reason_text');
            $table->timestamp('date_from')->nullable()->index();
            $table->timestamp('date_to')->nullable()->index();
            $table->json('scope')->nullable(); // message IDs, members, filters, export permission, etc.
            $table->string('status', 30)->default('pending')->index(); // pending, approved, rejected, expired, revoked.
            $table->timestamp('approved_at')->nullable();
            $table->timestamp('rejected_at')->nullable();
            $table->timestamp('revoked_at')->nullable();
            $table->timestamp('expires_at')->nullable()->index();
            $table->ipAddress('request_ip_address')->nullable();
            $table->text('request_user_agent')->nullable();
            $table->timestamps();

            $table->index(['organization_id', 'status'], 'chat_recovery_org_status_idx');
            $table->index(['requested_by', 'created_at'], 'chat_recovery_requested_created_idx');
            $table->index(['conversation_id', 'date_from', 'date_to'], 'chat_recovery_conv_range_idx');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('chat_recovery_requests');
    }
};
