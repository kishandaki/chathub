<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('chat_notification_preferences', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('organization_id')->nullable()->index();
            $table->unsignedBigInteger('user_id')->index();
            $table->string('event_type', 80)->index(); // direct_message, group_message, mention, file_received, added_to_group.
            $table->string('channel', 30)->index(); // in_app, push, email, local, sms.
            $table->boolean('is_enabled')->default(true)->index();
            $table->timestamp('muted_until')->nullable()->index();
            $table->json('rules')->nullable();
            $table->timestamps();

            $table->unique(['user_id', 'event_type', 'channel'], 'chat_notif_pref_user_event_channel_unique');
            $table->index(['organization_id', 'event_type', 'channel'], 'chat_notif_pref_org_event_channel_idx');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('chat_notification_preferences');
    }
};
