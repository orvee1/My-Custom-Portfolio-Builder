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

            $table->unsignedBigInteger('user_id')->unique();

            $table->string('slug')->unique();
            $table->string('portfolio_title');
            $table->string('full_name');
            $table->string('profession_title')->nullable();
            $table->string('brand_name')->nullable();

            $table->string('template_key')->default('premium_modern');
            $table->string('accent_color', 30)->nullable();
            $table->string('secondary_color', 30)->nullable();
            $table->string('font_family')->nullable();

            $table->string('email')->nullable();
            $table->string('phone', 30)->nullable();
            $table->string('whatsapp', 30)->nullable();
            $table->string('location')->nullable();
            $table->string('website')->nullable();

            $table->string('avatar')->nullable();
            $table->string('cover_image')->nullable();

            $table->text('short_bio')->nullable();
            $table->longText('about')->nullable();

            $table->json('highlight_stats')->nullable();
            $table->json('theme_settings')->nullable();

            $table->string('seo_title')->nullable();
            $table->text('seo_description')->nullable();
            $table->text('seo_keywords')->nullable();
            $table->string('og_image')->nullable();

            $table->boolean('resume_download_enabled')->default(true);
            $table->boolean('contact_form_enabled')->default(true);
            $table->boolean('show_social_links')->default(true);

            $table->boolean('is_public')->default(false);
            $table->timestamp('published_at')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->index('is_public', 'portfolios_is_public_idx');
            $table->index(['user_id', 'is_public'], 'portfolios_user_public_idx');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('portfolios');
    }
};
