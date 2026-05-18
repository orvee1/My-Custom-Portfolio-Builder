<?php

namespace App\Http\Controllers;

use App\Models\Portfolio;
use Illuminate\View\View;

class PublicPortfolioController extends Controller
{
    public function show(string $slug): View
    {
        $portfolio = Portfolio::query()
            ->with([
                'enabledProjects',
                'enabledExperiences',
                'enabledEducations',
                'enabledSkills',
                'enabledSocialLinks',
                'user:id,name,email',
            ])
            ->where('slug', $slug)
            ->where('status', 'published')
            ->where('is_public', true)
            ->firstOrFail();

        return view('public.portfolios.show', [
            'portfolio' => $portfolio,
            'isPreview' => false,
        ]);
    }
}
