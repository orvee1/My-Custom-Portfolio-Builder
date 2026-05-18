<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Concerns\ManagesPortfolioContent;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PortfolioContent\StoreSkillRequest;
use App\Models\Portfolio;
use App\Models\PortfolioSkill;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class PortfolioSkillController extends Controller
{
    use ManagesPortfolioContent;

    public function index(Portfolio $portfolio): View
    {
        $this->ensureCanManagePortfolio($portfolio);

        $skills = $portfolio->skills()->paginate(20);

        return view('admin.portfolio-content.skills.index', compact('portfolio', 'skills'));
    }

    public function store(StoreSkillRequest $request, Portfolio $portfolio): RedirectResponse
    {
        $this->ensureCanManagePortfolio($portfolio);

        DB::transaction(function () use ($request, $portfolio) {
            PortfolioSkill::create([
                ...$request->validated(),
                'portfolio_id' => $portfolio->id,
            ]);

            $this->touchPortfolio($portfolio);
        });

        return back()->with('success', 'Skill added successfully.');
    }

    public function edit(Portfolio $portfolio, PortfolioSkill $skill): View
    {
        $this->ensureCanManagePortfolio($portfolio);
        $this->ensureBelongsToPortfolio($skill, $portfolio);

        return view('admin.portfolio-content.skills.edit', compact('portfolio', 'skill'));
    }

    public function update(StoreSkillRequest $request, Portfolio $portfolio, PortfolioSkill $skill): RedirectResponse
    {
        $this->ensureCanManagePortfolio($portfolio);
        $this->ensureBelongsToPortfolio($skill, $portfolio);

        DB::transaction(function () use ($request, $portfolio, $skill) {
            $skill->update($request->validated());

            $this->touchPortfolio($portfolio);
        });

        return redirect()
            ->route('admin.portfolios.skills.index', $portfolio)
            ->with('success', 'Skill updated successfully.');
    }

    public function destroy(Portfolio $portfolio, PortfolioSkill $skill): RedirectResponse
    {
        $this->ensureCanManagePortfolio($portfolio);
        $this->ensureBelongsToPortfolio($skill, $portfolio);

        DB::transaction(function () use ($portfolio, $skill) {
            $skill->delete();

            $this->touchPortfolio($portfolio);
        });

        return back()->with('success', 'Skill deleted successfully.');
    }
}
