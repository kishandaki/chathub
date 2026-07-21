<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('chat_conversations', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->unsignedBigInteger('organization_id')->nullable()->index(); // Map to existing company/organization table.
            $table->string('type', 30)->default('direct')->index(); // direct, group, department, team, announcement, support.
            $table->string('name')->nullable();
            $table->text('description')->nullable();
            $table->string('avatar_path')->nullable();
            $table->string('reference_type', 50)->nullable()->index(); // department, team, project, etc.
            $table->unsignedBigInteger('reference_id')->nullable()->index();
            $table->string('encryption_mode', 50)->default('enterprise_recovery')->index(); // none, server, e2ee, enterprise_recovery.
            $table->boolean('recovery_enabled')->default(false)->index();
            $table->boolean('is_system_generated')->default(false)->index();
            $table->string('status', 30)->default('active')->index(); // active, archived, locked.
            $table->unsignedBigInteger('last_message_id')->nullable()->index();
            $table->timestamp('last_message_at')->nullable()->index();
            $table->unsignedBigInteger('created_by')->nullable()->index();
            $table->unsignedBigInteger('updated_by')->nullable()->index();
            $table->unsignedBigInteger('deleted_by')->nullable()->index();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['organization_id', 'type', 'status'], 'chat_conv_org_type_status_idx');
            $table->index(['organization_id', 'last_message_at'], 'chat_conv_org_last_msg_idx');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('chat_conversations');
    }
};
