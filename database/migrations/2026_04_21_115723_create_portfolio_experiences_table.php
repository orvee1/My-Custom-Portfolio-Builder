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

            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('portfolio_id');

            $table->string('company_name');
            $table->string('job_title');
            $table->string('employment_type')->nullable(); // full-time, part-time, freelance
            $table->string('location')->nullable();
            $table->string('company_logo')->nullable();

            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->boolean('is_current')->default(false);

            $table->text('summary')->nullable();
            $table->json('achievements')->nullable();

            $table->integer('sort_order')->default(0);
            $table->boolean('is_enabled')->default(true);

            $table->timestamps();
            $table->softDeletes();

            $table->index(['user_id', 'portfolio_id'], 'pe_user_portfolio_idx');
            $table->index(['portfolio_id', 'sort_order'], 'pe_portfolio_sort_idx');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('portfolio_experiences');
    }
};
