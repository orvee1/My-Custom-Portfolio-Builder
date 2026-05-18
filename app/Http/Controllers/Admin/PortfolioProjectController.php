<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Concerns\ManagesPortfolioContent;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PortfolioContent\StoreProjectRequest;
use App\Models\Portfolio;
use App\Models\PortfolioProject;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class PortfolioProjectController extends Controller
{
    use ManagesPortfolioContent;

    public function index(Portfolio $portfolio): View
    {
        $this->ensureCanManagePortfolio($portfolio);

        $projects = $portfolio->projects()->paginate(15);

        return view('admin.portfolio-content.projects.index', compact('portfolio', 'projects'));
    }

    public function store(StoreProjectRequest $request, Portfolio $portfolio): RedirectResponse
    {
        $this->ensureCanManagePortfolio($portfolio);

        DB::transaction(function () use ($request, $portfolio) {
            $data = $this->prepareData($request->validated(), $request);

            $data['portfolio_id'] = $portfolio->id;

            PortfolioProject::create($data);

            $this->touchPortfolio($portfolio);
        });

        return back()->with('success', 'Project added successfully.');
    }

    public function edit(Portfolio $portfolio, PortfolioProject $project): View
    {
        $this->ensureCanManagePortfolio($portfolio);
        $this->ensureBelongsToPortfolio($project, $portfolio);

        return view('admin.portfolio-content.projects.edit', compact('portfolio', 'project'));
    }

    public function update(StoreProjectRequest $request, Portfolio $portfolio, PortfolioProject $project): RedirectResponse
    {
        $this->ensureCanManagePortfolio($portfolio);
        $this->ensureBelongsToPortfolio($project, $portfolio);

        DB::transaction(function () use ($request, $portfolio, $project) {
            $data = $this->prepareData($request->validated(), $request, $project);

            $project->update($data);

            $this->touchPortfolio($portfolio);
        });

        return redirect()
            ->route('admin.portfolios.projects.index', $portfolio)
            ->with('success', 'Project updated successfully.');
    }

    public function destroy(Portfolio $portfolio, PortfolioProject $project): RedirectResponse
    {
        $this->ensureCanManagePortfolio($portfolio);
        $this->ensureBelongsToPortfolio($project, $portfolio);

        DB::transaction(function () use ($portfolio, $project) {
            $project->delete();

            $this->touchPortfolio($portfolio);
        });

        return back()->with('success', 'Project deleted successfully.');
    }

    private function prepareData(array $data, StoreProjectRequest $request, ?PortfolioProject $project = null): array
    {
        $data['tech_stack'] = $this->linesToArray($request->input('tech_stack_text'));
        $data['metrics'] = $this->linesToArray($request->input('metrics_text'));

        unset($data['tech_stack_text'], $data['metrics_text']);

        if ($request->hasFile('thumbnail')) {
            if ($project?->thumbnail) {
                Storage::disk('public')->delete($project->thumbnail);
            }

            $data['thumbnail'] = $request->file('thumbnail')->store('portfolios/projects/thumbnails', 'public');
        }

        if ($request->hasFile('banner_image')) {
            if ($project?->banner_image) {
                Storage::disk('public')->delete($project->banner_image);
            }

            $data['banner_image'] = $request->file('banner_image')->store('portfolios/projects/banners', 'public');
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
