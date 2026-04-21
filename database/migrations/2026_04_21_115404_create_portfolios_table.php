<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('portfolios', function (Blueprint $table) {
            $table->id();

            // one portfolio per admin user
            $table->unsignedBigInteger('user_id')->unique();

            $table->string('slug', 150)->unique();
            $table->string('portfolio_title', 150);
            $table->string('full_name', 150);
            $table->string('profession_title', 150)->nullable();
            $table->string('brand_name', 150)->nullable();
            $table->string('tagline', 255)->nullable();

            $table->enum('status', ['draft', 'published', 'archived'])->default('draft');
            $table->boolean('is_public')->default(false);
            $table->timestamp('published_at')->nullable();

            $table->string('template_key', 100)->default('premium_modern');
            $table->string('accent_color', 30)->nullable();
            $table->string('secondary_color', 30)->nullable();
            $table->string('font_family', 100)->nullable();

            $table->string('email', 150)->nullable();
            $table->string('phone', 30)->nullable();
            $table->string('whatsapp', 30)->nullable();
            $table->string('location', 150)->nullable();
            $table->string('website', 255)->nullable();

            $table->string('avatar', 255)->nullable();
            $table->string('cover_image', 255)->nullable();
            $table->string('resume_file', 255)->nullable();

            $table->text('short_bio')->nullable();
            $table->longText('about')->nullable();
            $table->json('highlight_stats')->nullable();
            $table->json('theme_settings')->nullable();

            $table->string('seo_title', 160)->nullable();
            $table->text('seo_description')->nullable();
            $table->text('seo_keywords')->nullable();
            $table->string('og_image', 255)->nullable();

            $table->boolean('resume_download_enabled')->default(true);
            $table->boolean('contact_form_enabled')->default(true);
            $table->boolean('show_social_links')->default(true);

            $table->timestamp('last_content_updated_at')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->index(['user_id', 'status'], 'portfolios_user_status_idx');
            $table->index(['is_public', 'status'], 'portfolios_public_status_idx');
            $table->index('published_at', 'portfolios_published_at_idx');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('portfolios');
    }
};
