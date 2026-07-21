<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('chat_user_presence', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('organization_id')->nullable()->index();
            $table->unsignedBigInteger('user_id')->index();
            $table->string('device_uuid', 100)->nullable()->index();
            $table->string('status', 30)->default('offline')->index(); // online, offline, away, busy.
            $table->foreignId('active_conversation_id')->nullable()->constrained('chat_conversations')->nullOnDelete();
            $table->string('socket_id')->nullable()->index();
            $table->timestamp('last_seen_at')->nullable()->index();
            $table->timestamp('expires_at')->nullable()->index();
            $table->json('metadata')->nullable();
            $table->timestamps();

            $table->unique(['user_id', 'device_uuid'], 'chat_presence_user_device_unique');
            $table->index(['organization_id', 'status'], 'chat_presence_org_status_idx');
            $table->index(['status', 'expires_at'], 'chat_presence_status_expires_idx');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('chat_user_presence');
    }
};
