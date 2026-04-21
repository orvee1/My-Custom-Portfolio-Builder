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
            $table->unsignedBigInteger('portfolio_id');

            $table->enum('section_type', ['system', 'custom'])->default('system');
            $table->string('system_key', 100)->nullable();    // hero, about, projects, skills
            $table->string('custom_slug', 150)->nullable();   // user defined slug for custom section

            $table->string('section_name', 150);
            $table->string('layout_key', 100)->nullable();
            $table->text('intro_text')->nullable();
            $table->json('config')->nullable();

            $table->integer('sort_order')->default(0);
            $table->boolean('is_enabled')->default(true);
            $table->boolean('is_deletable')->default(true);

            $table->timestamps();
            $table->softDeletes();

            $table->unique(['portfolio_id', 'system_key'], 'ps_portfolio_system_key_unique');
            $table->unique(['portfolio_id', 'custom_slug'], 'ps_portfolio_custom_slug_unique');

            $table->index(['portfolio_id', 'sort_order'], 'ps_portfolio_sort_idx');
            $table->index(['portfolio_id', 'is_enabled'], 'ps_portfolio_enabled_idx');
            $table->index('section_type', 'ps_section_type_idx');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('portfolio_sections');
    }
};
