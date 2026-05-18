<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Portfolio\UpdatePortfolioRequest;
use App\Models\Portfolio;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class PortfolioController extends Controller
{
    public function index(Request $request): View
    {
        abort_unless(auth()->user()?->isSuperAdmin(), 403);

        $portfolios = Portfolio::query()
            ->with('user:id,name,email,is_active')
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = trim((string) $request->search);

                $query->where(function ($subQuery) use ($search) {
                    $subQuery->where('portfolio_title', 'like', "%{$search}%")
                        ->orWhere('full_name', 'like', "%{$search}%")
                        ->orWhere('slug', 'like', "%{$search}%")
                        ->orWhereHas('user', function ($userQuery) use ($search) {
                            $userQuery->where('name', 'like', "%{$search}%")
                                ->orWhere('email', 'like', "%{$search}%");
                        });
                });
            })
            ->when($request->filled('status'), function ($query) use ($request) {
                $query->where('status', $request->status);
            })
            ->latest('id')
            ->paginate(15)
            ->withQueryString();

        return view('admin.portfolios.index', compact('portfolios'));
    }

    public function mine(): RedirectResponse
    {
        $user = auth()->user();

        $portfolio = $this->getOrCreatePortfolioForUser($user);

        return redirect()->route('admin.portfolios.edit', $portfolio);
    }

    public function edit(Portfolio $portfolio): View
    {
        $this->ensureCanManage($portfolio);

        return view('admin.portfolios.edit', [
            'portfolio' => $portfolio->load('user:id,name,email'),
            'publicUrl' => $portfolio->publicUrl(),
        ]);
    }

    public function update(UpdatePortfolioRequest $request, Portfolio $portfolio): RedirectResponse
    {
        $this->ensureCanManage($portfolio);

        $data = $request->validated();

        unset(
            $data['avatar'],
            $data['cover_image'],
            $data['resume_file'],
            $data['stat_label'],
            $data['stat_value'],
            $data['hero_layout'],
            $data['card_style'],
            $data['button_style'],
            $data['show_cover_overlay']
        );

        $data['highlight_stats'] = $this->buildHighlightStats($request);

        $data['theme_settings'] = [
            'hero_layout' => $request->input('hero_layout', 'split'),
            'card_style' => $request->input('card_style', 'soft'),
            'button_style' => $request->input('button_style', 'rounded'),
            'show_cover_overlay' => $request->boolean('show_cover_overlay'),
        ];

        $data['last_content_updated_at'] = now();

        DB::transaction(function () use ($request, $portfolio, $data) {
            if ($request->hasFile('avatar')) {
                $data['avatar'] = $this->storeFile(
                    $request,
                    'avatar',
                    'portfolios/avatars',
                    $portfolio->avatar
                );
            }

            if ($request->hasFile('cover_image')) {
                $data['cover_image'] = $this->storeFile(
                    $request,
                    'cover_image',
                    'portfolios/covers',
                    $portfolio->cover_image
                );
            }

            if ($request->hasFile('resume_file')) {
                $data['resume_file'] = $this->storeFile(
                    $request,
                    'resume_file',
                    'portfolios/resumes',
                    $portfolio->resume_file
                );
            }

            $portfolio->update($data);
        });

        return redirect()
            ->route('admin.portfolios.edit', $portfolio)
            ->with('success', 'Portfolio updated successfully.');
    }

    public function togglePublish(Portfolio $portfolio): RedirectResponse
    {
        $this->ensureCanManage($portfolio);

        if ($portfolio->status === 'published') {
            $portfolio->update([
                'status' => 'draft',
                'is_public' => false,
                'published_at' => null,
            ]);

            return back()->with('success', 'Portfolio moved to draft.');
        }

        if (! $portfolio->full_name || ! $portfolio->portfolio_title || ! $portfolio->slug) {
            return back()->withErrors([
                'portfolio' => 'Please complete portfolio title, full name, and slug before publishing.',
            ]);
        }

        $portfolio->update([
            'status' => 'published',
            'is_public' => true,
            'published_at' => now(),
        ]);

        return back()->with('success', 'Portfolio published successfully.');
    }

    public function preview(Portfolio $portfolio): View
    {
        $this->ensureCanManage($portfolio);

        return view('public.portfolios.show', [
            'portfolio' => $portfolio->load([
                'enabledProjects',
                'enabledExperiences',
                'enabledEducations',
                'enabledSkills',
                'enabledSocialLinks',
                'user:id,name,email',
            ]),
            'isPreview' => true,
        ]);
    }

    private function ensureCanManage(Portfolio $portfolio): void
    {
        $user = auth()->user();

        abort_unless(
            $user?->isSuperAdmin() || $portfolio->user_id === $user?->id,
            403
        );
    }

    private function getOrCreatePortfolioForUser(User $user): Portfolio
    {
        $portfolio = Portfolio::query()
            ->where('user_id', $user->id)
            ->first();

        if ($portfolio) {
            return $portfolio;
        }

        return Portfolio::create([
            'user_id' => $user->id,
            'slug' => $this->generateUniqueSlug($user->name),
            'portfolio_title' => $user->name."'s Portfolio",
            'full_name' => $user->name,
            'email' => $user->email,
            'status' => 'draft',
            'is_public' => false,
            'template_key' => 'premium_modern',
            'accent_color' => '#4f46e5',
            'secondary_color' => '#111827',
            'font_family' => 'Inter',
            'resume_download_enabled' => true,
            'contact_form_enabled' => true,
            'show_social_links' => true,
            'theme_settings' => [
                'hero_layout' => 'split',
                'card_style' => 'soft',
                'button_style' => 'rounded',
                'show_cover_overlay' => true,
            ],
        ]);
    }

    private function generateUniqueSlug(string $name): string
    {
        $baseSlug = Str::slug($name) ?: 'portfolio';
        $slug = $baseSlug;
        $counter = 1;

        while (Portfolio::query()->where('slug', $slug)->exists()) {
            $slug = $baseSlug.'-'.$counter;
            $counter++;
        }

        return $slug;
    }

    private function buildHighlightStats(Request $request): array
    {
        $labels = $request->input('stat_label', []);
        $values = $request->input('stat_value', []);

        $stats = [];

        foreach ($labels as $index => $label) {
            $label = trim((string) $label);
            $value = trim((string) ($values[$index] ?? ''));

            if ($label === '' && $value === '') {
                continue;
            }

            $stats[] = [
                'label' => $label,
                'value' => $value,
            ];
        }

        return $stats;
    }

    private function storeFile(Request $request, string $field, string $directory, ?string $oldPath = null): string
    {
        if ($oldPath) {
            Storage::disk('public')->delete($oldPath);
        }

        return $request->file($field)->store($directory, 'public');
    }
}
