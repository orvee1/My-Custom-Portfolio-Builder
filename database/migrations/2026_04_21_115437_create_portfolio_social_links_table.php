<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('portfolio_social_links', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('portfolio_id');

            $table->string('platform'); // github, linkedin, facebook, dribbble, behance
            $table->string('label')->nullable();
            $table->string('url');
            $table->string('icon')->nullable();

            $table->integer('sort_order')->default(0);
            $table->boolean('is_enabled')->default(true);

            $table->timestamps();
            $table->softDeletes();

            $table->index(['user_id', 'portfolio_id'], 'psl_user_portfolio_idx');
            $table->index(['portfolio_id', 'sort_order'], 'psl_portfolio_sort_idx');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('portfolio_social_links');
    }
};
