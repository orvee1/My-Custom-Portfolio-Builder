<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class PortfolioProject extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'portfolio_id',
        'title',
        'slug',
        'project_type',
        'category',
        'short_description',
        'long_description',
        'problem_statement',
        'solution_summary',
        'result_summary',
        'client_name',
        'project_url',
        'github_url',
        'figma_url',
        'case_study_url',
        'started_at',
        'ended_at',
        'thumbnail',
        'banner_image',
        'gallery',
        'tech_stack',
        'metrics',
        'is_featured',
        'is_enabled',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'started_at' => 'date',
            'ended_at' => 'date',
            'gallery' => 'array',
            'tech_stack' => 'array',
            'metrics' => 'array',
            'is_featured' => 'boolean',
            'is_enabled' => 'boolean',
        ];
    }

    public function portfolio(): BelongsTo
    {
        return $this->belongsTo(Portfolio::class, 'portfolio_id');
    }
}
