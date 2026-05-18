<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Portfolio extends Model
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
            'is_public'               => 'boolean',
            'published_at'            => 'datetime',
            'highlight_stats'         => 'array',
            'theme_settings'          => 'array',
            'resume_download_enabled' => 'boolean',
            'contact_form_enabled'    => 'boolean',
            'show_social_links'       => 'boolean',
            'last_content_updated_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function isPublished(): bool
    {
        return $this->status === 'published' && $this->is_public;
    }

    public function publicUrl(): string
    {
        return route('public.portfolios.show', $this->slug);
    }

    public function socialLinks(): HasMany
    {
        return $this->hasMany(PortfolioSocialLink::class, 'portfolio_id')
            ->orderBy('sort_order');
    }

    public function enabledSocialLinks(): HasMany
    {
        return $this->hasMany(PortfolioSocialLink::class, 'portfolio_id')
            ->where('is_enabled', true)
            ->orderBy('sort_order');
    }

    public function projects(): HasMany
    {
        return $this->hasMany(PortfolioProject::class, 'portfolio_id')
            ->orderBy('sort_order');
    }

    public function enabledProjects(): HasMany
    {
        return $this->hasMany(PortfolioProject::class, 'portfolio_id')
            ->where('is_enabled', true)
            ->orderBy('sort_order');
    }

    public function experiences(): HasMany
    {
        return $this->hasMany(PortfolioExperience::class, 'portfolio_id')
            ->orderBy('sort_order');
    }

    public function enabledExperiences(): HasMany
    {
        return $this->hasMany(PortfolioExperience::class, 'portfolio_id')
            ->where('is_enabled', true)
            ->orderBy('sort_order');
    }

    public function educations(): HasMany
    {
        return $this->hasMany(PortfolioEducation::class, 'portfolio_id')
            ->orderBy('sort_order');
    }

    public function enabledEducations(): HasMany
    {
        return $this->hasMany(PortfolioEducation::class, 'portfolio_id')
            ->where('is_enabled', true)
            ->orderBy('sort_order');
    }

    public function skills(): HasMany
    {
        return $this->hasMany(PortfolioSkill::class, 'portfolio_id')
            ->orderBy('sort_order');
    }

    public function enabledSkills(): HasMany
    {
        return $this->hasMany(PortfolioSkill::class, 'portfolio_id')
            ->where('is_enabled', true)
            ->orderBy('sort_order');
    }
}
