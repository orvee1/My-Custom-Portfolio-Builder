<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('approval_status', ['pending', 'approved', 'rejected'])
                ->default('approved')
                ->after('is_active');

            $table->timestamp('approved_at')->nullable()->after('approval_status');
            $table->unsignedBigInteger('approved_by')->nullable()->after('approved_at');

            $table->timestamp('rejected_at')->nullable()->after('approved_by');
            $table->text('rejection_reason')->nullable()->after('rejected_at');

            $table->index(['role', 'approval_status'], 'users_role_approval_status_idx');
            $table->index(['approval_status', 'is_active'], 'users_approval_active_idx');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex('users_role_approval_status_idx');
            $table->dropIndex('users_approval_active_idx');

            $table->dropColumn([
                'approval_status',
                'approved_at',
                'approved_by',
                'rejected_at',
                'rejection_reason',
            ]);
        });
    }
};
