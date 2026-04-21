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
            $table->unsignedBigInteger('portfolio_id');

            $table->string('name', 150);
            $table->string('email', 150);
            $table->string('phone', 30)->nullable();
            $table->string('subject', 180)->nullable();
            $table->longText('message');

            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->string('referrer_url', 500)->nullable();

            $table->enum('status', ['new', 'read', 'replied', 'archived'])->default('new');
            $table->timestamp('replied_at')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->index(['portfolio_id', 'status'], 'pcm_portfolio_status_idx');
            $table->index('created_at', 'pcm_created_at_idx');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('portfolio_contact_messages');
    }
};
