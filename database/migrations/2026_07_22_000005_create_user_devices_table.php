<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_devices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('device_id')->nullable();
            $table->string('device_name')->nullable();
            $table->string('platform')->nullable();
            $table->string('browser')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->timestamp('last_active_at')->nullable();
            $table->timestamp('trusted_at')->nullable();
            $table->timestamp('revoked_at')->nullable();
            $table->timestamps();

            $table->index(['user_id', 'device_id']);
            $table->index(['ip_address']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_devices');
    }
};