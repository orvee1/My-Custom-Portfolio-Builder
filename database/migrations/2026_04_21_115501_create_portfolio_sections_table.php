<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('portfolio_sections', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('portfolio_id');

            $table->enum('section_type', ['system', 'custom'])->default('system');

            $table->string('system_key')->nullable();   // hero, about, projects...
            $table->string('custom_slug')->nullable();  // user-defined unique slug for custom section

            $table->string('section_name');
            $table->string('layout_key')->nullable();   // grid, cards, timeline, split, masonry
            $table->text('intro_text')->nullable();
            $table->json('config')->nullable();         // colors, columns, spacing, card type, etc.

            $table->integer('sort_order')->default(0);
            $table->boolean('is_enabled')->default(true);
            $table->boolean('is_deletable')->default(true);

            $table->timestamps();
            $table->softDeletes();

            $table->unique(['portfolio_id', 'system_key'], 'ps_portfolio_system_key_unique');
            $table->unique(['portfolio_id', 'custom_slug'], 'ps_portfolio_custom_slug_unique');

            $table->index(['user_id', 'portfolio_id'], 'ps_user_portfolio_idx');
            $table->index(['portfolio_id', 'sort_order'], 'ps_portfolio_sort_idx');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('portfolio_sections');
    }
};
