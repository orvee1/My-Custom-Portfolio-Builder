<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Concerns\ManagesPortfolioContent;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PortfolioContent\StoreExperienceRequest;
use App\Models\Portfolio;
use App\Models\PortfolioExperience;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class PortfolioExperienceController extends Controller
{
    use ManagesPortfolioContent;

    public function index(Portfolio $portfolio): View
    {
        $this->ensureCanManagePortfolio($portfolio);

        $experiences = $portfolio->experiences()->paginate(15);

        return view('admin.portfolio-content.experiences.index', compact('portfolio', 'experiences'));
    }

    public function store(StoreExperienceRequest $request, Portfolio $portfolio): RedirectResponse
    {
        $this->ensureCanManagePortfolio($portfolio);

        DB::transaction(function () use ($request, $portfolio) {
            $data = $this->prepareData($request->validated(), $request);
            $data['portfolio_id'] = $portfolio->id;

            PortfolioExperience::create($data);

            $this->touchPortfolio($portfolio);
        });

        return back()->with('success', 'Experience added successfully.');
    }

    public function edit(Portfolio $portfolio, PortfolioExperience $experience): View
    {
        $this->ensureCanManagePortfolio($portfolio);
        $this->ensureBelongsToPortfolio($experience, $portfolio);

        return view('admin.portfolio-content.experiences.edit', compact('portfolio', 'experience'));
    }

    public function update(StoreExperienceRequest $request, Portfolio $portfolio, PortfolioExperience $experience): RedirectResponse
    {
        $this->ensureCanManagePortfolio($portfolio);
        $this->ensureBelongsToPortfolio($experience, $portfolio);

        DB::transaction(function () use ($request, $portfolio, $experience) {
            $experience->update($this->prepareData($request->validated(), $request, $experience));

            $this->touchPortfolio($portfolio);
        });

        return redirect()
            ->route('admin.portfolios.experiences.index', $portfolio)
            ->with('success', 'Experience updated successfully.');
    }

    public function destroy(Portfolio $portfolio, PortfolioExperience $experience): RedirectResponse
    {
        $this->ensureCanManagePortfolio($portfolio);
        $this->ensureBelongsToPortfolio($experience, $portfolio);

        DB::transaction(function () use ($portfolio, $experience) {
            $experience->delete();

            $this->touchPortfolio($portfolio);
        });

        return back()->with('success', 'Experience deleted successfully.');
    }

    private function prepareData(array $data, StoreExperienceRequest $request, ?PortfolioExperience $experience = null): array
    {
        $data['achievements'] = $this->linesToArray($request->input('achievements_text'));

        unset($data['achievements_text']);

        if ($data['is_current']) {
            $data['end_date'] = null;
        }

        if ($request->hasFile('company_logo')) {
            if ($experience?->company_logo) {
                Storage::disk('public')->delete($experience->company_logo);
            }

            $data['company_logo'] = $request->file('company_logo')->store('portfolios/experiences/logos', 'public');
        }

        return $data;
    }

    private function linesToArray(?string $text): array
    {
        if (! $text) {
            return [];
        }

        return collect(preg_split('/\r\n|\r|\n/', $text))
            ->map(fn ($item) => trim($item))
            ->filter()
            ->values()
            ->all();
    }
}
