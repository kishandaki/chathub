<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('chat_message_attachments', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('message_id')->constrained('chat_messages')->cascadeOnDelete();
            $table->foreignId('conversation_id')->constrained('chat_conversations')->cascadeOnDelete();
            $table->unsignedBigInteger('uploaded_by')->nullable()->index();
            $table->string('storage_disk', 50)->default('local')->index();
            $table->string('file_path');
            $table->string('original_name')->nullable(); // Encrypt at application layer if file names are sensitive.
            $table->string('mime_type', 120)->nullable()->index();
            $table->unsignedBigInteger('file_size')->default(0);
            $table->string('file_hash', 128)->nullable()->index();
            $table->longText('encrypted_file_key')->nullable();
            $table->string('nonce', 255)->nullable();
            $table->string('auth_tag', 255)->nullable();
            $table->string('thumbnail_path')->nullable();
            $table->string('preview_status', 30)->default('pending')->index(); // pending, ready, failed, skipped.
            $table->string('scan_status', 30)->default('pending')->index(); // pending, clean, infected, failed, skipped.
            $table->text('scan_result')->nullable();
            $table->json('metadata')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable()->index();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['conversation_id', 'created_at'], 'chat_attach_conv_created_idx');
            $table->index(['uploaded_by', 'created_at'], 'chat_attach_uploader_created_idx');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('chat_message_attachments');
    }
};
