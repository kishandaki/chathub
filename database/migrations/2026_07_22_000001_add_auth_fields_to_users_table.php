<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('uuid')->unique()->after('id');
            $table->unsignedBigInteger('organization_id')->nullable()->after('uuid');
            $table->string('employee_id')->nullable()->after('organization_id');
            $table->string('first_name')->nullable()->after('name');
            $table->string('last_name')->nullable()->after('first_name');
            $table->string('phone')->nullable()->after('email');
            $table->string('profile_photo_path')->nullable()->after('phone');
            $table->string('status')->default('active')->after('remember_token');
            $table->timestamp('last_login_at')->nullable()->after('status');
            $table->timestamp('last_active_at')->nullable()->after('last_login_at');
            $table->timestamp('password_changed_at')->nullable()->after('last_active_at');
            $table->unsignedInteger('failed_login_attempts')->default(0)->after('password_changed_at');
            $table->timestamp('locked_until')->nullable()->after('failed_login_attempts');
            $table->boolean('mfa_enabled')->default(false)->after('locked_until');
            $table->string('mfa_type')->nullable()->after('mfa_enabled');
            $table->string('timezone')->default('UTC')->after('mfa_type');
            $table->string('locale')->default('en')->after('timezone');
            $table->string('theme')->default('light')->after('locale');
            $table->unsignedBigInteger('created_by')->nullable()->after('theme');
            $table->unsignedBigInteger('updated_by')->nullable()->after('created_by');
            $table->unsignedBigInteger('deleted_by')->nullable()->after('updated_by');
            $table->softDeletes()->after('deleted_by');

            $table->index(['status']);
            $table->index(['locked_until']);
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'uuid',
                'organization_id',
                'employee_id',
                'first_name',
                'last_name',
                'phone',
                'profile_photo_path',
                'status',
                'last_login_at',
                'last_active_at',
                'password_changed_at',
                'failed_login_attempts',
                'locked_until',
                'mfa_enabled',
                'mfa_type',
                'timezone',
                'locale',
                'theme',
                'created_by',
                'updated_by',
                'deleted_by',
                'deleted_at',
            ]);
        });
    }
};