<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class PortfolioExperience extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'portfolio_id',
        'company_name',
        'job_title',
        'employment_type',
        'location',
        'company_logo',
        'start_date',
        'end_date',
        'is_current',
        'summary',
        'achievements',
        'sort_order',
        'is_enabled',
    ];

    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'end_date' => 'date',
            'is_current' => 'boolean',
            'achievements' => 'array',
            'is_enabled' => 'boolean',
        ];
    }

    public function portfolio(): BelongsTo
    {
        return $this->belongsTo(Portfolio::class, 'portfolio_id');
    }
}
