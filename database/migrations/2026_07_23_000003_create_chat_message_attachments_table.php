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
            $table->foreignId('message_id')->constrained('chat_messages')->cascadeOnDelete();
            $table->string('disk')->default('local'); // local, s3, etc.
            $table->string('path')->nullable();
            $table->string('file_name')->nullable();
            $table->string('mime_type')->nullable()->index();
            $table->string('extension')->nullable()->index();
            $table->unsignedBigInteger('size_bytes')->nullable();
            $table->string('preview_path')->nullable();
            $table->boolean('is_encrypted')->default(false)->index();
            $table->unsignedBigInteger('uploaded_by')->nullable()->index();
            $table->timestamps();

            $table->index(['message_id', 'created_at'], 'chat_attachments_msg_created_idx');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('chat_message_attachments');
    }
};