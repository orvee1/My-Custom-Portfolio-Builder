<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['super_admin', 'admin'])->default('admin')->after('email');
            $table->unsignedBigInteger('created_by')->nullable()->after('role');
            $table->boolean('is_active')->default(true)->after('created_by');
            $table->timestamp('last_login_at')->nullable()->after('is_active');
            $table->softDeletes();

            $table->index('created_by', 'users_created_by_idx');
            $table->index(['role', 'is_active'], 'users_role_is_active_idx');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex('users_created_by_idx');
            $table->dropIndex('users_role_is_active_idx');
            $table->dropSoftDeletes();

            $table->dropColumn([
                'role',
                'created_by',
                'is_active',
                'last_login_at',
            ]);
        });
    }
};
