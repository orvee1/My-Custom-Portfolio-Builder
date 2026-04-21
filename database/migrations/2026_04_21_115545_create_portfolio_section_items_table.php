<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('portfolio_section_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('portfolio_id');
            $table->unsignedBigInteger('section_id');

            $table->string('title', 150);
            $table->string('subtitle', 150)->nullable();
            $table->text('description')->nullable();

            $table->string('image', 255)->nullable();
            $table->string('link', 500)->nullable();
            $table->string('button_text', 100)->nullable();

            $table->json('meta')->nullable();

            $table->integer('sort_order')->default(0);
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_enabled')->default(true);

            $table->timestamps();
            $table->softDeletes();

            $table->index(['section_id', 'sort_order'], 'psi_section_sort_idx');
            $table->index(['portfolio_id', 'section_id'], 'psi_portfolio_section_idx');
            $table->index(['section_id', 'is_enabled'], 'psi_section_enabled_idx');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('portfolio_section_items');
    }
};
