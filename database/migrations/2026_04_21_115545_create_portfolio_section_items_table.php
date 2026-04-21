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

            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('portfolio_id');
            $table->unsignedBigInteger('section_id');

            $table->string('title');
            $table->string('subtitle')->nullable();
            $table->text('description')->nullable();

            $table->string('image')->nullable();
            $table->string('link')->nullable();
            $table->string('button_text')->nullable();

            $table->json('meta')->nullable();

            $table->integer('sort_order')->default(0);
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_enabled')->default(true);

            $table->timestamps();
            $table->softDeletes();

            $table->index(['user_id', 'portfolio_id'], 'psi_user_portfolio_idx');
            $table->index(['section_id', 'sort_order'], 'psi_section_sort_idx');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('portfolio_section_items');
    }
};
