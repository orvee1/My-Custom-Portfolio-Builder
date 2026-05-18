<?php

namespace App\Http\Controllers\Admin\Concerns;

use App\Models\Portfolio;
use Illuminate\Database\Eloquent\Model;

trait ManagesPortfolioContent
{
    protected function ensureCanManagePortfolio(Portfolio $portfolio): void
    {
        $user = auth()->user();

        abort_unless(
            $user?->isSuperAdmin() || $portfolio->user_id === $user?->id,
            403
        );
    }

    protected function ensureBelongsToPortfolio(Model $model, Portfolio $portfolio): void
    {
        abort_if((int) $model->portfolio_id !== (int) $portfolio->id, 404);
    }

    protected function touchPortfolio(Portfolio $portfolio): void
    {
        $portfolio->update([
            'last_content_updated_at' => now(),
        ]);
    }
}
