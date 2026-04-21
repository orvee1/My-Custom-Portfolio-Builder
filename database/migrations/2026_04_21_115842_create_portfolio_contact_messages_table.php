<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('portfolio_contact_messages', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('portfolio_id');

            $table->string('name');
            $table->string('email');
            $table->string('phone', 30)->nullable();
            $table->string('subject')->nullable();
            $table->longText('message');

            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();

            $table->boolean('is_read')->default(false);
            $table->timestamp('replied_at')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->index(['user_id', 'portfolio_id'], 'pcm_user_portfolio_idx');
            $table->index('is_read', 'pcm_is_read_idx');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('portfolio_contact_messages');
    }
};
