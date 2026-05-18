<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Concerns\ManagesPortfolioContent;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PortfolioContent\StoreEducationRequest;
use App\Models\Portfolio;
use App\Models\PortfolioEducation;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class PortfolioEducationController extends Controller
{
    use ManagesPortfolioContent;

    public function index(Portfolio $portfolio): View
    {
        $this->ensureCanManagePortfolio($portfolio);

        $educations = $portfolio->educations()->paginate(15);

        return view('admin.portfolio-content.educations.index', compact('portfolio', 'educations'));
    }

    public function store(StoreEducationRequest $request, Portfolio $portfolio): RedirectResponse
    {
        $this->ensureCanManagePortfolio($portfolio);

        DB::transaction(function () use ($request, $portfolio) {
            $data = $this->prepareData($request->validated(), $request);
            $data['portfolio_id'] = $portfolio->id;

            PortfolioEducation::create($data);

            $this->touchPortfolio($portfolio);
        });

        return back()->with('success', 'Education added successfully.');
    }

    public function edit(Portfolio $portfolio, PortfolioEducation $education): View
    {
        $this->ensureCanManagePortfolio($portfolio);
        $this->ensureBelongsToPortfolio($education, $portfolio);

        return view('admin.portfolio-content.educations.edit', compact('portfolio', 'education'));
    }

    public function update(StoreEducationRequest $request, Portfolio $portfolio, PortfolioEducation $education): RedirectResponse
    {
        $this->ensureCanManagePortfolio($portfolio);
        $this->ensureBelongsToPortfolio($education, $portfolio);

        DB::transaction(function () use ($request, $portfolio, $education) {
            $education->update($this->prepareData($request->validated(), $request, $education));

            $this->touchPortfolio($portfolio);
        });

        return redirect()
            ->route('admin.portfolios.educations.index', $portfolio)
            ->with('success', 'Education updated successfully.');
    }

    public function destroy(Portfolio $portfolio, PortfolioEducation $education): RedirectResponse
    {
        $this->ensureCanManagePortfolio($portfolio);
        $this->ensureBelongsToPortfolio($education, $portfolio);

        DB::transaction(function () use ($portfolio, $education) {
            $education->delete();

            $this->touchPortfolio($portfolio);
        });

        return back()->with('success', 'Education deleted successfully.');
    }

    private function prepareData(array $data, StoreEducationRequest $request, ?PortfolioEducation $education = null): array
    {
        if ($data['is_current']) {
            $data['end_date'] = null;
        }

        if ($request->hasFile('institution_logo')) {
            if ($education?->institution_logo) {
                Storage::disk('public')->delete($education->institution_logo);
            }

            $data['institution_logo'] = $request->file('institution_logo')->store('portfolios/educations/logos', 'public');
        }

        return $data;
    }
}
