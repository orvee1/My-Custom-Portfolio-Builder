<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class PortfolioEducation extends Model
{
    use SoftDeletes;

    protected $table = 'portfolio_educations';

    protected $fillable = [
        'portfolio_id',
        'institution_name',
        'degree',
        'field_of_study',
        'institution_logo',
        'start_date',
        'end_date',
        'is_current',
        'grade',
        'description',
        'sort_order',
        'is_enabled',
    ];

    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'end_date' => 'date',
            'is_current' => 'boolean',
            'is_enabled' => 'boolean',
        ];
    }

    public function portfolio(): BelongsTo
    {
        return $this->belongsTo(Portfolio::class, 'portfolio_id');
    }
}
