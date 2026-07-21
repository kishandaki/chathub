<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('chat_settings', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->unsignedBigInteger('organization_id')->nullable()->index();
            $table->string('setting_key', 120);
            $table->json('setting_value')->nullable();
            $table->string('data_type', 30)->default('json'); // string, number, boolean, json, encrypted.
            $table->boolean('is_encrypted')->default(false)->index();
            $table->boolean('editable_by_admin')->default(true)->index();
            $table->text('description')->nullable();
            $table->unsignedBigInteger('created_by')->nullable()->index();
            $table->unsignedBigInteger('updated_by')->nullable()->index();
            $table->timestamps();

            $table->unique(['organization_id', 'setting_key'], 'chat_settings_org_key_unique');
            $table->index(['setting_key', 'editable_by_admin'], 'chat_settings_key_editable_idx');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('chat_settings');
    }
};
