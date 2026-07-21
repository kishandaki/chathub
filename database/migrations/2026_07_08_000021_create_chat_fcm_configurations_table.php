<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('chat_fcm_configurations', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->unsignedBigInteger('organization_id')->nullable()->index();
            $table->string('project_id')->nullable();
            $table->text('vapid_public_key')->nullable();
            $table->longText('vapid_private_key_encrypted')->nullable();
            $table->longText('service_account_json_encrypted')->nullable();
            $table->boolean('is_active')->default(true)->index();
            $table->timestamp('last_tested_at')->nullable();
            $table->string('last_test_status', 30)->nullable();
            $table->text('last_test_error')->nullable();
            $table->unsignedBigInteger('created_by')->nullable()->index();
            $table->unsignedBigInteger('updated_by')->nullable()->index();
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['organization_id', 'project_id'], 'chat_fcm_org_project_unique');
            $table->index(['organization_id', 'is_active'], 'chat_fcm_org_active_idx');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('chat_fcm_configurations');
    }
};
