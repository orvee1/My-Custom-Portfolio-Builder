<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('portfolio_skills', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('portfolio_id');

            $table->string('category', 100)->nullable();
            $table->string('name', 120);
            $table->unsignedTinyInteger('proficiency')->nullable(); // 1-100
            $table->decimal('years_of_experience', 4, 1)->nullable();
            $table->string('icon', 255)->nullable();

            $table->boolean('is_highlighted')->default(false);
            $table->boolean('is_enabled')->default(true);
            $table->integer('sort_order')->default(0);

            $table->timestamps();
            $table->softDeletes();

            $table->index(['portfolio_id', 'category'], 'pskill_portfolio_category_idx');
            $table->index(['portfolio_id', 'sort_order'], 'pskill_portfolio_sort_idx');
            $table->index(['portfolio_id', 'is_highlighted'], 'pskill_portfolio_highlighted_idx');
            $table->index(['portfolio_id', 'is_enabled'], 'pskill_portfolio_enabled_idx');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('portfolio_skills');
    }
};
