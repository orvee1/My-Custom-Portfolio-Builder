<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('portfolio_experiences', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('portfolio_id');

            $table->string('company_name', 180);
            $table->string('job_title', 180);
            $table->string('employment_type', 100)->nullable();
            $table->string('location', 150)->nullable();
            $table->string('company_logo', 255)->nullable();

            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->boolean('is_current')->default(false);

            $table->text('summary')->nullable();
            $table->json('achievements')->nullable();

            $table->integer('sort_order')->default(0);
            $table->boolean('is_enabled')->default(true);

            $table->timestamps();
            $table->softDeletes();

            $table->index(['portfolio_id', 'sort_order'], 'pe_portfolio_sort_idx');
            $table->index(['portfolio_id', 'is_current'], 'pe_portfolio_current_idx');
            $table->index(['portfolio_id', 'is_enabled'], 'pe_portfolio_enabled_idx');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('portfolio_experiences');
    }
};
