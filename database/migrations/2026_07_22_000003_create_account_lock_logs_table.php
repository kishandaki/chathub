<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('account_lock_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->unsignedBigInteger('locked_by')->nullable();
            $table->string('reason')->nullable();
            $table->unsignedInteger('failed_attempts');
            $table->timestamp('locked_until')->nullable();
            $table->timestamp('unlocked_at')->nullable();
            $table->timestamps();

            $table->index(['user_id', 'locked_until']);
            $table->index(['locked_by']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('account_lock_logs');
    }
};