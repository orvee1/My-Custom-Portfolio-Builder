<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Concerns\ManagesPortfolioContent;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PortfolioContent\StoreSocialLinkRequest;
use App\Models\Portfolio;
use App\Models\PortfolioSocialLink;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class PortfolioSocialLinkController extends Controller
{
    use ManagesPortfolioContent;

    public function index(Portfolio $portfolio): View
    {
        $this->ensureCanManagePortfolio($portfolio);

        $socialLinks = $portfolio->socialLinks()->paginate(20);

        return view('admin.portfolio-content.social-links.index', compact('portfolio', 'socialLinks'));
    }

    public function store(StoreSocialLinkRequest $request, Portfolio $portfolio): RedirectResponse
    {
        $this->ensureCanManagePortfolio($portfolio);

        DB::transaction(function () use ($request, $portfolio) {
            PortfolioSocialLink::create([
                ...$request->validated(),
                'portfolio_id' => $portfolio->id,
            ]);

            $this->touchPortfolio($portfolio);
        });

        return back()->with('success', 'Social link added successfully.');
    }

    public function edit(Portfolio $portfolio, PortfolioSocialLink $socialLink): View
    {
        $this->ensureCanManagePortfolio($portfolio);
        $this->ensureBelongsToPortfolio($socialLink, $portfolio);

        return view('admin.portfolio-content.social-links.edit', compact('portfolio', 'socialLink'));
    }

    public function update(StoreSocialLinkRequest $request, Portfolio $portfolio, PortfolioSocialLink $socialLink): RedirectResponse
    {
        $this->ensureCanManagePortfolio($portfolio);
        $this->ensureBelongsToPortfolio($socialLink, $portfolio);

        DB::transaction(function () use ($request, $portfolio, $socialLink) {
            $socialLink->update($request->validated());

            $this->touchPortfolio($portfolio);
        });

        return redirect()
            ->route('admin.portfolios.social-links.index', $portfolio)
            ->with('success', 'Social link updated successfully.');
    }

    public function destroy(Portfolio $portfolio, PortfolioSocialLink $socialLink): RedirectResponse
    {
        $this->ensureCanManagePortfolio($portfolio);
        $this->ensureBelongsToPortfolio($socialLink, $portfolio);

        DB::transaction(function () use ($portfolio, $socialLink) {
            $socialLink->delete();

            $this->touchPortfolio($portfolio);
        });

        return back()->with('success', 'Social link deleted successfully.');
    }
}
