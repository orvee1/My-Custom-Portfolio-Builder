<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('portfolio_projects', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('portfolio_id');

            $table->string('title', 180);
            $table->string('slug', 180);
            $table->string('project_type', 100)->nullable();
            $table->string('category', 100)->nullable();

            $table->text('short_description')->nullable();
            $table->longText('long_description')->nullable();

            $table->text('problem_statement')->nullable();
            $table->text('solution_summary')->nullable();
            $table->text('result_summary')->nullable();

            $table->string('client_name', 150)->nullable();
            $table->string('project_url', 500)->nullable();
            $table->string('github_url', 500)->nullable();
            $table->string('figma_url', 500)->nullable();
            $table->string('case_study_url', 500)->nullable();

            $table->date('started_at')->nullable();
            $table->date('ended_at')->nullable();

            $table->string('thumbnail', 255)->nullable();
            $table->string('banner_image', 255)->nullable();
            $table->json('gallery')->nullable();
            $table->json('tech_stack')->nullable();
            $table->json('metrics')->nullable();

            $table->boolean('is_featured')->default(false);
            $table->boolean('is_enabled')->default(true);
            $table->integer('sort_order')->default(0);

            $table->timestamps();
            $table->softDeletes();

            $table->unique(['portfolio_id', 'slug'], 'pp_portfolio_slug_unique');
            $table->index(['portfolio_id', 'is_featured'], 'pp_portfolio_featured_idx');
            $table->index(['portfolio_id', 'sort_order'], 'pp_portfolio_sort_idx');
            $table->index(['portfolio_id', 'is_enabled'], 'pp_portfolio_enabled_idx');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('portfolio_projects');
    }
};
