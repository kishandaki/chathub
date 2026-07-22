<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('login_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('email');
            $table->string('status'); // success, failed
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->string('failure_reason')->nullable();
            $table->timestamp('logged_in_at')->nullable();
            $table->timestamps();

            $table->index(['user_id', 'logged_in_at']);
            $table->index(['email']);
            $table->index(['status']);
            $table->index(['ip_address']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('login_histories');
    }
};