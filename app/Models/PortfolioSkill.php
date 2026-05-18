<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class PortfolioSkill extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'portfolio_id',
        'category',
        'name',
        'proficiency',
        'years_of_experience',
        'icon',
        'is_highlighted',
        'is_enabled',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'proficiency' => 'integer',
            'years_of_experience' => 'decimal:1',
            'is_highlighted' => 'boolean',
            'is_enabled' => 'boolean',
        ];
    }

    public function portfolio(): BelongsTo
    {
        return $this->belongsTo(Portfolio::class, 'portfolio_id');
    }
}
