<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('portfolio_educations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('portfolio_id');

            $table->string('institution_name', 180);
            $table->string('degree', 180)->nullable();
            $table->string('field_of_study', 180)->nullable();
            $table->string('institution_logo', 255)->nullable();

            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->boolean('is_current')->default(false);

            $table->string('grade', 100)->nullable();
            $table->text('description')->nullable();

            $table->integer('sort_order')->default(0);
            $table->boolean('is_enabled')->default(true);

            $table->timestamps();
            $table->softDeletes();

            $table->index(['portfolio_id', 'sort_order'], 'pedu_portfolio_sort_idx');
            $table->index(['portfolio_id', 'is_current'], 'pedu_portfolio_current_idx');
            $table->index(['portfolio_id', 'is_enabled'], 'pedu_portfolio_enabled_idx');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('portfolio_educations');
    }
};
