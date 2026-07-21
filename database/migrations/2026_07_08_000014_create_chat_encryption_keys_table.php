<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('chat_encryption_keys', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->unsignedBigInteger('organization_id')->nullable()->index();
            $table->string('owner_type', 50)->index(); // organization, user, device, conversation, recovery.
            $table->unsignedBigInteger('owner_id')->nullable()->index();
            $table->string('key_purpose', 80)->index(); // identity, device, conversation, recovery_public, wrapped_private.
            $table->longText('public_key')->nullable();
            $table->longText('encrypted_private_key')->nullable(); // Never store plain private keys.
            $table->json('wrapped_key_metadata')->nullable();
            $table->unsignedInteger('key_version')->default(1)->index();
            $table->string('algorithm', 80)->nullable(); // Example: X25519, AES-256-GCM, RSA-OAEP.
            $table->string('status', 30)->default('active')->index(); // active, rotated, revoked, expired.
            $table->timestamp('valid_from')->nullable()->index();
            $table->timestamp('valid_until')->nullable()->index();
            $table->unsignedBigInteger('rotated_from_id')->nullable()->index();
            $table->unsignedBigInteger('created_by')->nullable()->index();
            $table->unsignedBigInteger('revoked_by')->nullable()->index();
            $table->timestamp('revoked_at')->nullable()->index();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['owner_type', 'owner_id', 'key_purpose'], 'chat_keys_owner_purpose_idx');
            $table->index(['organization_id', 'status'], 'chat_keys_org_status_idx');
            $table->index(['key_purpose', 'key_version'], 'chat_keys_purpose_version_idx');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('chat_encryption_keys');
    }
};
