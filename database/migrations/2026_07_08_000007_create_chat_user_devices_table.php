<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('chat_user_devices', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->unsignedBigInteger('organization_id')->nullable()->index();
            $table->unsignedBigInteger('user_id')->index();
            $table->string('device_uuid', 100);
            $table->string('device_type', 30)->default('web')->index(); // web, ios, android.
            $table->string('device_name')->nullable();
            $table->string('browser')->nullable();
            $table->string('platform')->nullable();
            $table->text('push_token')->nullable();
            $table->text('fcm_token')->nullable();
            $table->longText('public_identity_key')->nullable();
            $table->longText('public_prekey')->nullable();
            $table->longText('signed_prekey')->nullable();
            $table->unsignedInteger('key_version')->default(1);
            $table->boolean('is_trusted')->default(false)->index();
            $table->timestamp('last_active_at')->nullable()->index();
            $table->timestamp('revoked_at')->nullable()->index();
            $table->unsignedBigInteger('revoked_by')->nullable()->index();
            $table->ipAddress('last_ip_address')->nullable();
            $table->text('user_agent')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['user_id', 'device_uuid'], 'chat_devices_user_device_unique');
            $table->index(['organization_id', 'device_type'], 'chat_devices_org_type_idx');
            $table->index(['user_id', 'revoked_at'], 'chat_devices_user_revoked_idx');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('chat_user_devices');
    }
};
