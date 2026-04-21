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
            $table->unsignedBigInteger('portfolio_id');

            $table->string('platform', 50); // github, linkedin, facebook, dribbble, behance
            $table->string('label', 100)->nullable();
            $table->string('url', 500);
            $table->string('icon', 100)->nullable();

            $table->integer('sort_order')->default(0);
            $table->boolean('is_enabled')->default(true);

            $table->timestamps();
            $table->softDeletes();

            $table->index(['portfolio_id', 'sort_order'], 'psl_portfolio_sort_idx');
            $table->index(['portfolio_id', 'is_enabled'], 'psl_portfolio_enabled_idx');
            $table->index('platform', 'psl_platform_idx');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('portfolio_social_links');
    }
};
