<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class PortFolio extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'slug',
        'portfolio_title',
        'full_name',
        'profession_title',
        'brand_name',
        'tagline',
        'status',
        'is_public',
        'published_at',
        'template_key',
        'accent_color',
        'secondary_color',
        'font_family',
        'email',
        'phone',
        'whatsapp',
        'location',
        'website',
        'avatar',
        'cover_image',
        'resume_file',
        'short_bio',
        'about',
        'highlight_stats',
        'theme_settings',
        'seo_title',
        'seo_description',
        'seo_keywords',
        'og_image',
        'resume_download_enabled',
        'contact_form_enabled',
        'show_social_links',
        'last_content_updated_at',
    ];

    protected function casts(): array
    {
        return [
            'is_public' => 'boolean',
            'published_at' => 'datetime',
            'highlight_stats' => 'array',
            'theme_settings' => 'array',
            'resume_download_enabled' => 'boolean',
            'contact_form_enabled' => 'boolean',
            'show_social_links' => 'boolean',
            'last_content_updated_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
